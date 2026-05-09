/**
 * resources/js/kasir.js
 *
 * Cara kerja komunikasi Blade → JS:
 * Blade tidak bisa langsung menulis variabel PHP ke file .js yang di-load Vite,
 * karena file .js diproses sebelum request terjadi.
 *
 * Solusinya: Blade menulis data ke window.KasirConfig (objek global)
 * di dalam tag <script> kecil di blade, lalu kasir.js membacanya dari sini.
 * Lihat bagian bawah index.blade.php untuk <script> inisialisasinya.
 */

// ─────────────────────────────────────────────────────────────
// VARIABEL GLOBAL
// Diisi oleh initKasir() yang dipanggil dari blade
// ─────────────────────────────────────────────────────────────
let cart = {};
let totalHarga = 0;
let CSRF = '';
let ROUTES = {};

// ─────────────────────────────────────────────────────────────
// INIT — Dipanggil dari blade setelah DOM siap
// ─────────────────────────────────────────────────────────────
window.initKasir = function (cartData, csrfToken, routes) {
    cart = cartData;
    CSRF = csrfToken;
    ROUTES = routes;

    renderCart();
    updateJam();
    setInterval(updateJam, 1000);

    // Listener pencarian produk
    const searchInput = document.getElementById('searchProduk');
    if (searchInput) {
        searchInput.addEventListener('input', filterProduk);
    }

    // Event delegation untuk tombol di card produk
    // Lebih efisien daripada onclick di setiap elemen HTML
    document.getElementById('listProduk')?.addEventListener('click', function (e) {
        const card = e.target.closest('.btn-cart');
        if (card) {
            const idProduk = card.dataset.id;
            tambahKeCart(idProduk);
        }
    });
};

// ─────────────────────────────────────────────────────────────
// JAM REALTIME
// ─────────────────────────────────────────────────────────────
function updateJam() {
    const el = document.getElementById('jam');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID');
}

// ─────────────────────────────────────────────────────────────
// TAMBAH PRODUK KE CART
// ─────────────────────────────────────────────────────────────
async function tambahKeCart(idProduk) {
    try {
        animasiCard(idProduk);
        const res = await kirimRequest(ROUTES.tambah, { id_produk: idProduk });
        const data = await res.json();

        if (data.success) {
            cart = data.cart;
            renderCart();
            tampilkanNotif(data.message, 'success');
        } else {
            tampilkanNotif(data.message || 'Gagal menambahkan produk', 'error');
        }
    } catch (err) {
        console.error('tambahKeCart error:', err);
        tampilkanNotif('Terjadi kesalahan koneksi', 'error');
    }
}

function animasiCard(idProduk) {
    const card = document.querySelector(`[data-id="${idProduk}"]`);
    if (!card) return;
    card.style.transform = 'scale(0.95)';
    card.style.opacity = '0.7';
    setTimeout(() => {
        card.style.transform = '';
        card.style.opacity = '';
    }, 150);
}

// ─────────────────────────────────────────────────────────────
// KURANGI QUANTITY
// ─────────────────────────────────────────────────────────────
window.kurangiCart = async function (idProduk) {
    try {
        const res = await kirimRequest(ROUTES.kurangi, { id_produk: idProduk });
        const data = await res.json();
        if (data.success) { cart = data.cart; renderCart(); }
    } catch (err) {
        console.error('kurangiCart error:', err);
    }
};

// ─────────────────────────────────────────────────────────────
// HAPUS ITEM DARI CART
// ─────────────────────────────────────────────────────────────
window.hapusCart = async function (idProduk) {
    try {
        const res = await kirimRequest(ROUTES.hapus, { id_produk: idProduk });
        const data = await res.json();
        if (data.success) {
            cart = data.cart;
            renderCart();
            tampilkanNotif('Produk dihapus dari cart', 'warning');
        }
    } catch (err) {
        console.error('hapusCart error:', err);
    }
};

// ─────────────────────────────────────────────────────────────
// KOSONGKAN CART
// ─────────────────────────────────────────────────────────────
window.clearCart = async function () {
    if (!confirm('Yakin ingin mengosongkan cart?')) return;
    try {
        const res = await kirimRequest(ROUTES.clear, {});
        const data = await res.json();
        if (data.success) {
            cart = {};
            renderCart();
            tampilkanNotif('Cart berhasil dikosongkan', 'warning');
        }
    } catch (err) {
        console.error('clearCart error:', err);
    }
};

// ─────────────────────────────────────────────────────────────
// RENDER TAMPILAN CART
// ─────────────────────────────────────────────────────────────
function renderCart() {
    const container = document.getElementById('cartItems');
    const countEl = document.getElementById('cartCount');
    const totalEl = document.getElementById('totalHarga');

    // Object.values() → ubah object cart menjadi array
    // supaya bisa di-loop dan di-reduce
    const items = Object.values(cart);

    totalHarga = items.reduce((sum, item) => sum + parseFloat(item.subtotal), 0);

    // Update badge
    if (countEl) {
        countEl.textContent = items.length;
        countEl.style.display = items.length > 0 ? 'flex' : 'none';
    }

    if (totalEl) totalEl.textContent = formatRupiah(totalHarga);
    if (!container) return;

    // Tampilkan state kosong
    if (items.length === 0) {
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center py-10 text-forest-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-3 opacity-40"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h11
                           M7 13L5.4 5M17 17a2 2 0 11-4 0 2 2 0 014 0zM9 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-sm font-medium opacity-60">Cart masih kosong</p>
                <p class="text-xs opacity-40 mt-1">Pilih produk di sebelah kiri</p>
            </div>`;

        const uangInput = document.getElementById('uangPelanggan');
        if (uangInput) uangInput.value = '';
        sembunyikanKembalian();
        return;
    }

    // Render setiap item
    container.innerHTML = items.map(item => `
        <div class="group flex flex-col gap-1 py-3
                    border-b border-forest-700/40 last:border-0">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-forest-100 truncate">
                        ${escapeHtml(item.nama_produk)}
                    </p>
                    <p class="text-xs text-forest-400">${formatRupiah(item.harga)} / pcs</p>
                </div>
                <button onclick="hapusCart('${item.id_produk}')"
                    class="shrink-0 w-6 h-6 flex items-center justify-center rounded-full
                           text-forest-500 hover:bg-red-500/20 hover:text-red-400
                           transition-all opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center rounded-lg overflow-hidden
                            border border-forest-600/50">
                    <button onclick="kurangiCart('${item.id_produk}')"
                        class="w-7 h-7 flex items-center justify-center
                               text-forest-300 hover:bg-forest-600 hover:text-white
                               transition-colors font-bold text-base">−</button>
                    <span class="w-8 text-center text-sm font-bold
                                 text-forest-100 bg-forest-700/50">
                        ${item.quantity}
                    </span>
                    <button onclick="tambahKeCart('${item.id_produk}')"
                        class="w-7 h-7 flex items-center justify-center
                               text-forest-300 hover:bg-forest-600 hover:text-white
                               transition-colors font-bold text-base">+</button>
                </div>
                <span class="text-sm font-bold text-tea-400">
                    ${formatRupiah(item.subtotal)}
                </span>
            </div>
        </div>
    `).join('');

    hitungKembalian();
}

// ─────────────────────────────────────────────────────────────
// HITUNG KEMBALIAN
// ─────────────────────────────────────────────────────────────
window.hitungKembalian = function () {
    const uangInput = document.getElementById('uangPelanggan');
    if (!uangInput) return;

    const uang = parseFloat(uangInput.value) || 0;
    const kembalian = uang - totalHarga;
    const box = document.getElementById('kembalianBox');
    const nominalEl = document.getElementById('kembalianNominal');
    const labelEl = document.getElementById('kembalianLabel');

    if (uang > 0) {
        if (box) box.classList.remove('hidden');

        if (kembalian >= 0) {
            if (box) {
                box.className = 'flex items-center justify-between px-3 py-2.5 rounded-xl border border-forest-500/40 bg-forest-700/30 transition-all';
            }
            if (labelEl) {
                labelEl.textContent = 'Kembalian';
                labelEl.className = 'text-xs text-forest-400';
            }
            if (nominalEl) {
                nominalEl.textContent = formatRupiah(kembalian);
                nominalEl.className = 'font-bold text-forest-300';
            }
        } else {
            if (box) {
                box.className = 'flex items-center justify-between px-3 py-2.5 rounded-xl border border-red-500/40 bg-red-900/20 transition-all';
            }
            if (labelEl) {
                labelEl.textContent = 'Kurang';
                labelEl.className = 'text-xs text-red-400';
            }
            if (nominalEl) {
                nominalEl.textContent = '− ' + formatRupiah(Math.abs(kembalian));
                nominalEl.className = 'font-bold text-red-400';
            }
        }
    } else {
        sembunyikanKembalian();
    }
};

function sembunyikanKembalian() {
    const box = document.getElementById('kembalianBox');
    if (box) box.classList.add('hidden');
}

// ─────────────────────────────────────────────────────────────
// TOMBOL UANG PAS
// ─────────────────────────────────────────────────────────────
window.uangPas = function () {
    const uangInput = document.getElementById('uangPelanggan');
    if (uangInput) {
        uangInput.value = totalHarga;
        window.hitungKembalian();
        tampilkanNotif('Uang pas dimasukkan', 'success');
    }
};

// ─────────────────────────────────────────────────────────────
// TOMBOL SELANJUTNYA → PROSES TRANSAKSI
// ─────────────────────────────────────────────────────────────
window.selanjutnya = async function () {
    const items = Object.values(cart);
    if (items.length === 0) {
        tampilkanNotif('Cart masih kosong!', 'warning'); return;
    }

    const uang = parseFloat(document.getElementById('uangPelanggan')?.value) || 0;
    if (uang <= 0) {
        tampilkanNotif('Masukkan uang pelanggan!', 'warning'); return;
    }
    if (uang < totalHarga) {
        tampilkanNotif('Uang pelanggan tidak cukup!', 'error'); return;
    }

    const cartSnapshot = JSON.parse(JSON.stringify(cart));

    // Loading state pada tombol
    const btn = document.getElementById('btnSelanjutnya');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
        </svg>`;
    }

    try {
        const res = await kirimRequest(ROUTES.proses, { uang_pelanggan: uang });
        const data = await res.json();

        if (data.success) {
            tampilkanModalTransaksi(data, cartSnapshot);
        } else {
            tampilkanNotif(data.message || 'Transaksi gagal!', 'error');
        }
    } catch (err) {
        console.error('selanjutnya error:', err);
        tampilkanNotif('Terjadi kesalahan, coba lagi', 'error');
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = `<span>Selanjutnya</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>`;
        }
    }
};

// ─────────────────────────────────────────────────────────────
// TAMPILKAN MODAL HASIL TRANSAKSI
// ─────────────────────────────────────────────────────────────
function tampilkanModalTransaksi(data, cartSnapshot) {
    setTextContent('modalIdTransaksi', data.transaksi.id_transaksi);
    setTextContent('modalTanggal', new Date().toLocaleString('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric',
        hour: '2-digit', minute: '2-digit',
    }));

    const tbody = document.getElementById('modalDetailProduk');
    if (tbody) {
        tbody.innerHTML = Object.values(cartSnapshot).map(item => `
            <tr class="border-b border-forest-700/30">
                <td class="py-2 text-sm text-forest-200">${escapeHtml(item.nama_produk)}</td>
                <td class="py-2 text-center text-sm text-forest-400">${item.quantity}×</td>
                <td class="py-2 text-right text-sm font-semibold text-tea-400">
                    ${formatRupiah(item.subtotal)}
                </td>
            </tr>
        `).join('');
    }

    setTextContent('modalTotal', formatRupiah(data.total));
    setTextContent('modalUang', formatRupiah(data.uang));
    setTextContent('modalKembalian', formatRupiah(data.kembalian));

    const modal = document.getElementById('modalTransaksi');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

// ─────────────────────────────────────────────────────────────
// TUTUP MODAL & RESET
// ─────────────────────────────────────────────────────────────
window.tutupModal = function () {
    const modal = document.getElementById('modalTransaksi');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
};

window.selesaiTransaksi = function () {
    window.tutupModal();
    // Reset cart lokal (session sudah dihapus di server)
    cart = {};
    renderCart();
    const uangInput = document.getElementById('uangPelanggan');
    if (uangInput) uangInput.value = '';
    sembunyikanKembalian();
    tampilkanNotif('Siap untuk transaksi berikutnya!', 'success');
};

// ─────────────────────────────────────────────────────────────
// PENCARIAN PRODUK
// ─────────────────────────────────────────────────────────────
function filterProduk() {
    const keyword = document.getElementById('searchProduk')?.value.toLowerCase() || '';
    document.querySelectorAll('.produk-item').forEach(el => {
        const nama = el.querySelector('[data-nama]')?.textContent?.toLowerCase() || '';
        el.style.display = nama.includes(keyword) ? '' : 'none';
    });
}

// ─────────────────────────────────────────────────────────────
// HELPER: Kirim AJAX Request (reusable untuk semua POST)
// ─────────────────────────────────────────────────────────────
function kirimRequest(url, body) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
        },
        body: JSON.stringify(body),
    });
}

// ─────────────────────────────────────────────────────────────
// HELPER: Format angka ke Rupiah
// ─────────────────────────────────────────────────────────────
function formatRupiah(angka) {
    return 'Rp\u00A0' + parseFloat(angka).toLocaleString('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });
}

// ─────────────────────────────────────────────────────────────
// HELPER: Escape HTML untuk mencegah XSS injection
// ─────────────────────────────────────────────────────────────
function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

// ─────────────────────────────────────────────────────────────
// HELPER: Set textContent by element ID
// ─────────────────────────────────────────────────────────────
function setTextContent(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
}

// ─────────────────────────────────────────────────────────────
// HELPER: Tampilkan Toast Notifikasi
// ─────────────────────────────────────────────────────────────
function tampilkanNotif(pesan, tipe = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const config = {
        success: { bg: 'bg-forest-600', border: 'border-forest-400/30', icon: '✓' },
        warning: { bg: 'bg-tea-600', border: 'border-tea-400/30', icon: '⚠' },
        error: { bg: 'bg-red-700', border: 'border-red-400/30', icon: '✕' },
    };
    const c = config[tipe] || config.success;

    const toast = document.createElement('div');
    toast.className = `flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl
        border ${c.border} ${c.bg} text-white text-sm font-medium
        transform translate-x-full transition-transform duration-300 ease-out`;
    toast.innerHTML = `
        <span class="shrink-0 w-5 h-5 flex items-center justify-center
                     rounded-full bg-white/20 text-xs font-bold">${c.icon}</span>
        <span>${escapeHtml(pesan)}</span>`;

    container.appendChild(toast);

    // Animasi masuk
    requestAnimationFrame(() => {
        requestAnimationFrame(() => toast.classList.remove('translate-x-full'));
    });

    // Auto hapus setelah 2.5 detik
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}
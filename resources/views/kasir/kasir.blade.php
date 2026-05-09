<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token wajib ada untuk AJAX POST request di Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir — POS System</title>
    @vite(['resources/js/kasir.js', 'resources/css/app.css', 'resources/css/kasir.css'])




</head>

{{-- Letakkan ini tepat sebelum </body> --}}
<script>
    /**
     * Jembatan antara Laravel/Blade dan kasir.js
     *
     * Kenapa perlu ini?
     * File kasir.js diproses oleh Vite sebagai file statis,
     * jadi tidak bisa langsung membaca variabel PHP.
     * Solusinya: Blade menulis data ke dalam pemanggilan fungsi initKasir()
     * yang sudah didefinisikan di kasir.js.
     */
    document.addEventListener('DOMContentLoaded', function() {
        initKasir(
            @json($cart), // PHP array cart dari session → JS object
            "{{ csrf_token() }}", // CSRF token Laravel untuk keamanan POST
            {
                tambah: "{{ route('kasir.cart.tambah') }}",
                kurangi: "{{ route('kasir.cart.kurangi') }}",
                hapus: "{{ route('kasir.cart.hapus') }}",
                clear: "{{ route('kasir.cart.clear') }}",
                proses: "{{ route('kasir.proses') }}",
            }
        );
    });
</script>

{{-- Background utama menggunakan warna forest terdalam --}}

<body class="bg-tea-100 text-forest-100 min-h-screen">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- NAVBAR                                      --}}
    {{-- ═══════════════════════════════════════════ --}}
    <nav
        class="sticky top-0 z-40 flex items-center justify-between px-6 py-3
                bg-forest-900 backdrop-blur-sm border-b border-forest-700/40 shadow-lg">

        <div class="flex items-center gap-3">
            {{-- Logo / Brand --}}
            <div class="w-8 h-8 rounded-lg bg-forest-600 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-forest-100" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h11M17 17a2 2 0 11-4 0 2 2 0 014 0zM9 17a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="font-display text-lg font-bold tracking-wide text-forest-100">
                POS <span class="text-forest-400">Kasir</span>
            </span>
        </div>

        {{-- Jam Realtime --}}
        <div class="flex items-center gap-2 text-sm text-forest-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="jam" class="font-mono font-semibold text-forest-300"></span>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- LAYOUT UTAMA: 2 KOLOM                       --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="flex h-[calc(100vh-57px)]">

        {{-- ─────────────────────────────────────── --}}
        {{-- KOLOM KIRI: Daftar Produk               --}}
        {{-- ─────────────────────────────────────── --}}
        <div class="flex-1 flex flex-col overflow-hidden p-4 gap-4">

            {{-- Search Bar --}}
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-forest-500 pointer-events-none"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchProduk"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl
                           bg-forest-800/60 border border-forest-700/50
                           text-forest-100 placeholder-forest-500
                           focus:outline-none focus:border-forest-500 focus:ring-1 focus:ring-forest-500/30
                           text-sm transition-all"
                    placeholder="Cari produk...">
            </div>

            {{-- Grid Produk --}}
            <div class="flex-1 overflow-y-auto pr-1">
                <div class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3" id="listProduk">

                    {{-- Loop semua produk dari database --}}
                    @forelse($produk as $item)
                        <div class="produk-item">
                            {{--
                            data-id dipakai oleh kasir.js untuk animasi card
                            data-nama dipakai untuk fitur pencarian
                            onclick memanggil fungsi dari kasir.js
                        --}}
                            <div class="btn-cart produk-card cursor-pointer rounded-xl overflow-hidden
                                    bg-forest-800/50 border border-forest-700/40
                                    hover:border-forest-500/60 hover:shadow-lg hover:shadow-forest-900/50
                                   select-none"
                                data-id="{{ $item->id_produk }}">

                                {{-- Gambar / Placeholder --}}
                                @if ($item->foto_produk)
                                    <img src="{{ asset('foto_produk/' . $item->foto_produk) }}"
                                        alt="{{ $item->nama_produk }}" class="w-full h-[12rem] object-cover">
                                @else
                                    <div class="w-full h-[12rem] bg-forest-700/40 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-forest-500/50"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-2.5">
                                    <p class="text-xs  text-forest-950 font-black leading-snug line-clamp-2 mb-1"
                                        data-nama>{{ $item->nama_produk }}</p>
                                    <p class="text-xs font-bold text-forest-800">
                                        Rp {{ number_format($item->harga_produk, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    @empty
                        {{-- State kosong jika tidak ada produk --}}
                        <div class="col-span-full flex flex-col items-center justify-center py-20 text-forest-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-30" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="font-semibold opacity-50">Tidak ada produk tersedia</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        {{-- ─────────────────────────────────────── --}}
        {{-- KOLOM KANAN: Panel Cart                 --}}
        {{-- ─────────────────────────────────────── --}}
        <div class="w-80 xl:w-96 flex flex-col
                    bg-forest-900/90 border-l border-forest-700/40">

            {{-- Header Cart --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-forest-700/40">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-forest-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h11M17 17a2 2 0 11-4 0 2 2 0 014 0zM9 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="font-display font-bold text-forest-100">Pesanan</h2>
                </div>
                {{-- Badge jumlah item --}}
                <span id="cartCount"
                    class="hidden w-6 h-6 items-center justify-center rounded-full
                           bg-forest-600 text-forest-100 text-xs font-bold">0</span>
            </div>

            {{-- List Item Cart (scrollable) --}}
            <div id="cartItems" class="flex-1 overflow-y-auto px-5 py-2">
                {{-- Diisi oleh renderCart() di kasir.js --}}
                <div class="flex flex-col items-center justify-center py-10 text-forest-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 mb-3 opacity-40" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h11M7 13L5.4 5M17 17a2 2 0 11-4 0 2 2 0 014 0zM9 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-sm font-medium opacity-60">Cart masih kosong</p>
                    <p class="text-xs opacity-40 mt-1">Pilih produk di sebelah kiri</p>
                </div>
            </div>

            {{-- Footer Cart: Total, Input Uang, Tombol --}}
            <div class="border-t border-forest-700/40 px-5 py-4 flex flex-col gap-3">

                {{-- Total Harga --}}
                <div class="flex items-center justify-between">
                    <span class="text-sm text-forest-400 font-medium">Total Pembayaran</span>
                    <span id="totalHarga" class="font-display text-xl font-bold text-tea-400">Rp 0</span>
                </div>

                {{-- Input Uang Pelanggan --}}
                <div class="space-y-1.5">
                    <label class="text-xs text-forest-400 font-semibold uppercase tracking-wider">
                        Uang Pelanggan
                    </label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-forest-500 font-semibold">Rp</span>
                        <input type="number" id="uangPelanggan"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl
                                   bg-forest-800 border border-forest-600/50
                                   text-forest-100 text-sm font-semibold
                                   placeholder-forest-600
                                   focus:outline-none focus:border-tea-500/60 focus:ring-1 focus:ring-tea-500/20
                                   transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                            placeholder="0" min="0" oninput="hitungKembalian()">
                    </div>

                    {{-- Tombol Uang Pas --}}
                    <button onclick="uangPas()"
                        class="w-full py-2 rounded-lg text-xs font-bold uppercase tracking-wider
                               border border-tea-600/40 text-tea-400
                               hover:bg-tea-600/10 hover:border-tea-500/60
                               active:scale-95 transition-all">
                        ✓ Uang Pas
                    </button>
                </div>

                {{-- Kembalian (hidden by default) --}}
                <div id="kembalianBox"
                    class="hidden flex items-center justify-between px-3 py-2.5 rounded-xl
                           border border-forest-500/40 bg-forest-700/30 transition-all">
                    <span id="kembalianLabel" class="text-xs text-forest-400">Kembalian</span>
                    <span id="kembalianNominal" class="font-bold text-forest-300">Rp 0</span>
                </div>

                {{-- Tombol Selanjutnya --}}
                <button id="btnSelanjutnya" onclick="selanjutnya()"
                    class="w-full flex items-center justify-center gap-2 py-3 rounded-xl
                           bg-forest-600 hover:bg-forest-500 active:bg-forest-700
                           text-white font-bold text-sm
                           shadow-lg shadow-forest-900/50
                           active:scale-98 transition-all duration-150">
                    <span>Selanjutnya</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>

                {{-- Tombol Clear Cart --}}
                <button onclick="clearCart()"
                    class="w-full py-2 rounded-lg text-xs font-semibold
                           text-forest-500 hover:text-red-400 hover:bg-red-500/10
                           active:scale-95 transition-all">
                    Kosongkan Cart
                </button>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- MODAL: Detail Transaksi                                 --}}
    {{-- Muncul setelah kasir menekan tombol "Selanjutnya"       --}}
    {{-- dan transaksi berhasil disimpan ke database             --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div id="modalTransaksi"
        class="hidden fixed inset-0 z-50 items-center justify-center p-4
               bg-forest-950/80 backdrop-blur-sm">

        {{-- Panel Modal --}}
        <div data-modal-panel
            class="w-full max-w-md rounded-2xl overflow-hidden shadow-2xl
                   bg-forest-900 border border-forest-700/50
                   scale-100 opacity-100 transition-all duration-200">

            {{-- Header Modal --}}
            <div class="px-6 py-5 bg-forest-800/60 border-b border-forest-700/40">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-forest-600/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-forest-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-forest-100">Transaksi Berhasil</h3>
                        <p class="text-xs text-forest-400" id="modalTanggal">—</p>
                    </div>
                </div>
                {{-- Nomor Transaksi --}}
                <div class="mt-3 px-3 py-2 rounded-lg bg-forest-700/40 border border-forest-600/30">
                    <p class="text-xs text-forest-500 mb-0.5">No. Transaksi</p>
                    <p class="font-mono font-bold text-tea-400 text-sm" id="modalIdTransaksi">—</p>
                </div>
            </div>

            {{-- Body Modal --}}
            <div class="px-6 py-4 max-h-64 overflow-y-auto">
                <p class="text-xs text-forest-500 uppercase tracking-wider font-semibold mb-2">
                    Detail Produk
                </p>
                <table class="w-full">
                    <thead>
                        <tr class="text-xs text-forest-500 border-b border-forest-700/40">
                            <th class="text-left pb-2 font-semibold">Produk</th>
                            <th class="text-center pb-2 font-semibold w-12">Qty</th>
                            <th class="text-right pb-2 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modalDetailProduk">
                        {{-- Diisi oleh tampilkanModalTransaksi() di kasir.js --}}
                    </tbody>
                </table>
            </div>

            {{-- Footer Modal: Ringkasan Pembayaran --}}
            <div class="px-6 py-4 bg-forest-800/40 border-t border-forest-700/40 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-forest-400">Total Belanja</span>
                    <span class="font-semibold text-forest-200" id="modalTotal">—</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-forest-400">Uang Pelanggan</span>
                    <span class="font-semibold text-forest-200" id="modalUang">—</span>
                </div>
                <div class="flex justify-between pt-2 border-t border-forest-700/40">
                    <span class="font-bold text-forest-300">Kembalian</span>
                    <span class="font-display font-bold text-xl text-tea-400" id="modalKembalian">—</span>
                </div>
            </div>

            {{-- Tombol Close --}}
            <div class="px-6 pb-5">
                <button onclick="selesaiTransaksi()"
                    class="w-full py-3 rounded-xl font-bold text-sm
                           bg-forest-600 hover:bg-forest-500 text-white
                           active:scale-95 transition-all shadow-lg shadow-forest-950/50">
                    Selesai & Transaksi Baru
                </button>
            </div>

        </div>
    </div>

    <div id="toastContainer"
        class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 items-end pointer-events-none">
    </div>

</body>

</html>

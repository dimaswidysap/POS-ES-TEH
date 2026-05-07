<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KasirController extends Controller
{
    /**
     * Halaman utama kasir - menampilkan semua produk
     */
    public function index()
    {
        // Ambil semua produk dari database
        $produk = Produk::all();

        // Ambil cart dari session, kalau kosong pakai array kosong
        $cart = session('cart', []);

        return view('kasir.kasir', compact('produk', 'cart'));
    }

    /**
     * Tambah produk ke cart session
     * Dipanggil via AJAX dari halaman kasir
     */
    public function tambahCart(Request $request)
    {
        // Validasi input yang dikirim
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk', // Harus ada di tabel produk
        ]);

        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($request->id_produk);

        // Ambil cart yang ada di session
        $cart = session('cart', []);

        // Cek apakah produk sudah ada di cart
        if (isset($cart[$produk->id_produk])) {
            // Kalau sudah ada, tambah quantity-nya
            $cart[$produk->id_produk]['quantity']++;
            $cart[$produk->id_produk]['subtotal'] =
                $cart[$produk->id_produk]['quantity'] * $cart[$produk->id_produk]['harga'];
        } else {
            // Kalau belum ada, buat item baru di cart
            $cart[$produk->id_produk] = [
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga_produk,
                'quantity' => 1,
                'subtotal' => $produk->harga_produk,
                'foto_produk' => $produk->foto_produk,
            ];
        }

        // Simpan cart yang sudah diupdate ke session
        session(['cart' => $cart]);

        // Hitung total keseluruhan cart
        $total = array_sum(array_column($cart, 'subtotal'));

        // Kembalikan response JSON untuk AJAX
        return response()->json([
            'success' => true,
            'message' => $produk->nama_produk.' ditambahkan ke cart',
            'cart' => $cart,
            'total' => $total,
            'count' => count($cart), // Jumlah jenis produk di cart
        ]);
    }

    /**
     * Kurangi quantity produk di cart
     */
    public function kurangiCart(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
        ]);

        $cart = session('cart', []);
        $id = $request->id_produk;

        // Cek apakah produk ada di cart
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                // Kurangi quantity jika lebih dari 1
                $cart[$id]['quantity']--;
                $cart[$id]['subtotal'] = $cart[$id]['quantity'] * $cart[$id]['harga'];
            } else {
                // Hapus dari cart jika quantity sudah 1
                unset($cart[$id]);
            }
        }

        session(['cart' => $cart]);
        $total = array_sum(array_column($cart, 'subtotal'));

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $total,
            'count' => count($cart),
        ]);
    }

    /**
     * Hapus produk dari cart
     */
    public function hapusCart(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
        ]);

        $cart = session('cart', []);
        unset($cart[$request->id_produk]); // Hapus item dari array cart
        session(['cart' => $cart]);

        $total = array_sum(array_column($cart, 'subtotal'));

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $total,
            'count' => count($cart),
        ]);
    }

    /**
     * Proses transaksi - simpan ke database
     */
    public function prosesTransaksi(Request $request)
    {
        // Validasi uang pelanggan
        $request->validate([
            'uang_pelanggan' => 'required|numeric|min:0',
        ]);

        $cart = session('cart', []);

        // Cek cart tidak boleh kosong
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong! Tambahkan produk terlebih dahulu.',
            ], 400);
        }

        // Hitung total
        $total = array_sum(array_column($cart, 'subtotal'));
        $uangPelanggan = $request->uang_pelanggan;

        // Validasi uang cukup
        if ($uangPelanggan < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Uang pelanggan tidak cukup!',
            ], 400);
        }

        $kembalian = $uangPelanggan - $total;

        /**
         * DB::transaction() memastikan semua query berhasil
         * Jika salah satu gagal, semua dibatalkan (rollback)
         * Ini penting untuk menjaga konsistensi data
         */
        try {
            $transaksi = DB::transaction(function () use ($cart, $total, $uangPelanggan, $kembalian) {

                // Generate ID transaksi unik (format: TRX + 7 digit angka acak)
                $idTransaksi = 'TRX'.str_pad(rand(1, 9999999), 7, '0', STR_PAD_LEFT);

                // Simpan header transaksi
                $transaksi = Transaksi::create([
                    'id_transaksi' => $idTransaksi,
                    'total_harga' => $total,
                    'uang_pelanggan' => $uangPelanggan,
                    'kembalian' => $kembalian,
                    'tanggal_transaksi' => now(),
                ]);

                // Simpan detail setiap produk
                foreach ($cart as $item) {
                    DetailTransaksi::create([
                        'id_transaksi' => $idTransaksi,
                        'id_produk' => $item['id_produk'],
                        'quantity' => $item['quantity'],
                        'harga_satuan' => $item['harga'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                return $transaksi;
            });

            // Hapus cart dari session setelah transaksi berhasil
            session()->forget('cart');

            // Load relasi detail + produk untuk ditampilkan di popup
            $transaksi->load('details.produk');

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan!',
                'transaksi' => $transaksi,
                'cart' => $cart,         // Kirim cart sebelum dikosongkan
                'total' => $total,
                'uang' => $uangPelanggan,
                'kembalian' => $kembalian,
            ]);

        } catch (\Exception $e) {
            Log::error('Transaksi gagal: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal! Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Kosongkan semua cart
     */
    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart berhasil dikosongkan',
        ]);
    }
}

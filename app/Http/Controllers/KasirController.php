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
    public function index()
    {
        $produk = Produk::all();
        $cart = session('cart', []);

        return view('kasir.kasir', compact('produk', 'cart'));
    }

    public function tambahCart(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
        ]);

        // id sekarang integer, cast dulu agar cocok dengan key array session
        $idProduk = (int) $request->id_produk;
        $produk = Produk::findOrFail($idProduk);
        $cart = session('cart', []);

        if (isset($cart[$idProduk])) {
            $cart[$idProduk]['quantity']++;
            $cart[$idProduk]['subtotal'] =
                $cart[$idProduk]['quantity'] * $cart[$idProduk]['harga'];
        } else {
            $cart[$idProduk] = [
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'harga' => (float) $produk->harga_produk,
                'quantity' => 1,
                'subtotal' => (float) $produk->harga_produk,
                'foto_produk' => $produk->foto_produk,
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => $produk->nama_produk.' ditambahkan ke cart',
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'subtotal')),
            'count' => count($cart),
        ]);
    }

    public function kurangiCart(Request $request)
    {
        $request->validate(['id_produk' => 'required']);

        $cart = session('cart', []);
        $idProduk = (int) $request->id_produk;

        if (isset($cart[$idProduk])) {
            if ($cart[$idProduk]['quantity'] > 1) {
                $cart[$idProduk]['quantity']--;
                $cart[$idProduk]['subtotal'] =
                    $cart[$idProduk]['quantity'] * $cart[$idProduk]['harga'];
            } else {
                unset($cart[$idProduk]);
            }
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'subtotal')),
            'count' => count($cart),
        ]);
    }

    public function hapusCart(Request $request)
    {
        $request->validate(['id_produk' => 'required']);

        $cart = session('cart', []);
        unset($cart[(int) $request->id_produk]);
        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'subtotal')),
            'count' => count($cart),
        ]);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response()->json(['success' => true]);
    }

    public function prosesTransaksi(Request $request)
    {
        $request->validate([
            'uang_pelanggan' => 'required|numeric|min:0',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong!',
            ], 400);
        }

        $total = array_sum(array_column($cart, 'subtotal'));
        $uangPelanggan = (float) $request->uang_pelanggan;

        if ($uangPelanggan < $total) {
            return response()->json([
                'success' => false,
                'message' => 'Uang pelanggan tidak cukup!',
            ], 400);
        }

        $kembalian = $uangPelanggan - $total;

        try {
            $transaksi = DB::transaction(function () use ($cart, $total, $uangPelanggan, $kembalian) {

                // id_transaksi di-generate otomatis oleh database (auto increment)
                // tidak perlu diisi secara manual
                $transaksi = Transaksi::create([
                    'total_harga' => $total,
                    'uang_pelanggan' => $uangPelanggan,
                    'kembalian' => $kembalian,
                    'tanggal_transaksi' => now(),
                ]);

                foreach ($cart as $item) {
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_produk' => $item['id_produk'],
                        'quantity' => $item['quantity'],
                        'harga_satuan' => $item['harga'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                return $transaksi;
            });

            // Simpan cart untuk dikirim ke response sebelum dihapus
            $cartSnapshot = $cart;
            session()->forget('cart');

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaksi' => $transaksi,
                'cart' => $cartSnapshot,
                'total' => $total,
                'uang' => $uangPelanggan,
                'kembalian' => $kembalian,
            ]);

        } catch (\Exception $e) {
            Log::error('Transaksi gagal: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal, coba lagi.',
            ], 500);
        }
    }
}

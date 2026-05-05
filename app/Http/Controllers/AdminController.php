<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function admin()
    {
        return view('admin.admin');
    }

    public function menu()
    {
        $produk = Produk::all();

        return view('admin.menu', compact('produk'));
    }

    public function detail($id)
    {

        $produk = Produk::findOrFail($id);

        return view('admin.detail', compact('produk'));
    }

    public function tambahProduk()
    {

        return view('admin.tambah-produk');
    }

    public function simpanProduk(Request $request)
    {
        $request->validate(
            [
                'nama_produk' => 'required|string|max:50',
                'harga_produk' => 'required|numeric|min:0',
                'deskripsi_produk' => 'required',
                // 'foto' => 'required|image|mimes:jpg,png,jpeg|max:2000',
            ],
            [
                'nama_produk.required' => 'Nama produk jangan kosong!',
                'harga_produk.required' => 'Harga produk jangan kosong!',
                'deskripsi_produk.required' => 'Deskripsi produk jangan kosong!',
                // 'foto.required' => 'Wajib mengupload foto!',
                // 'foto.mimes' => 'Foto hanya boleh jpg, png, jpeg',
                // 'foto.max' => 'Ukuran foto maksimal 2MB',
            ],

        );

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            // 'foto' => $namaFile,
            'deskripsi' => $request->deskripsi_produk,
        ]);

        return redirect()->route('admin.menu')->with('success', 'Produk berhasil ditambahkan');
    }

    public function order()
    {
        return view('admin.order');
    }

    public function user()
    {
        return view('admin.user');
    }
}

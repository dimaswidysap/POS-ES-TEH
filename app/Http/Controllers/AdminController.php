<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
                'foto_produk' => 'required|image|mimes:jpg,png,jpeg|max:3000',
            ],
            [
                'nama_produk.required' => 'Nama produk jangan kosong!',
                'harga_produk.required' => 'Harga produk jangan kosong!',
                'deskripsi_produk.required' => 'Deskripsi produk jangan kosong!',
                'foto_produk.required' => 'Wajib mengupload foto!',
                'foto_produk.mimes' => 'Foto hanya boleh jpg, png, jpeg',
                'foto_produk.max' => 'Ukuran foto maksimal 3MB',
            ],

        );

        $namaFile = Str::random(5).'.'.$request->foto_produk->extension();
        $request->foto_produk->move(public_path('foto_produk'), $namaFile);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'foto_produk' => $namaFile,
            'deskripsi' => $request->deskripsi_produk,
        ]);

        return redirect()->route('admin.menu')->with('success', 'Produk berhasil ditambahkan');
    }

    public function editProduk($id)
    {
        $produk = Produk::findOrFail($id);

        return view('admin.edit-produk', compact('produk'));
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate(
            [
                'nama_produk_update' => 'required|string|max:50',
                'harga_produk_update' => 'required|numeric|min:0',
                'deskripsi_produk_update' => 'required',
                'foto_produk_update' => 'nullable|image|mimes:jpg,png,jpeg|max:3000',
            ],
            [
                'nama_produk_update.required' => 'Nama produk jangan kosong!',
                'harga_produk_update.required' => 'Harga produk jangan kosong!',
                'deskripsi_produk_update.required' => 'Deskripsi produk jangan kosong!',
                'foto_produk_update.image' => 'File harus berupa gambar!',
                'foto_produk_update.mimes' => 'Foto hanya boleh jpg, png, jpeg',
                'foto_produk_update.max' => 'Ukuran foto maksimal 3MB',
            ]
        );

        $produk = Produk::findOrFail($id);

        // Default pakai foto lama
        $namaFile = $produk->foto_produk;

        if ($request->hasFile('foto_produk_update')) {

            // Hapus foto lama jika ada
            $pathLama = public_path('foto_produk/'.$produk->foto_produk);
            if ($produk->foto_produk && File::exists($pathLama)) {
                File::delete($pathLama);
            }

            // Upload foto baru
            $file = $request->file('foto_produk_update');
            $namaFile = Str::random(10).'.'.$file->extension();
            $file->move(public_path('foto_produk'), $namaFile);
        }

        // Update langsung dari object (lebih clean)
        $produk->update([
            'nama_produk' => $request->nama_produk_update,
            'harga_produk' => $request->harga_produk_update,
            'foto_produk' => $namaFile,
            'deskripsi' => $request->deskripsi_produk_update,
        ]);

        return redirect()->route('admin.menu')->with('success', 'Produk berhasil diupdate');
    }

    public function hapusProduk($id)
    {
        $produk = Produk::findOrFail($id);

        $pathLama = public_path('foto_produk/'.$produk->foto_produk);
        if ($produk->foto_produk && File::exists($pathLama)) {
            File::delete($pathLama);
        }

        $produk->delete();

        return redirect()->route('admin.menu')->with('success', 'Produk berhasil dihapus');
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

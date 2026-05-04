<?php

namespace App\Http\Controllers;

use App\Models\Produk;

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

    public function order()
    {
        return view('admin.order');
    }

    public function user()
    {
        return view('admin.user');
    }
}

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin.index');

    //
    Route::get('/menu', [AdminController::class, 'menu'])->name('admin.menu');
    Route::get('/menu/detail/{id}', [AdminController::class, 'detail'])->name('admin.menu.detail');
    Route::get('/menu/tambah-produk', [AdminController::class, 'tambahProduk'])->name('admin.menu.tambahProduk');
    Route::post('/menu/simpan-produk', [AdminController::class, 'simpanProduk'])->name('admin.menu.simpanProduk');
    Route::get('/menu/edit-produk/{id}', [AdminController::class, 'editProduk'])->name('admin.menu.editProduk');
    Route::post('/menu/update-produk/{id}', [AdminController::class, 'updateProduk'])->name('admin.menu.updateProduk');
    Route::delete('admin/menu/hapus-produk/{id}', [AdminController::class, 'hapusProduk'])->name('admin.menu.hapusProduk');

    //

    Route::get('/order', [AdminController::class, 'order'])->name('admin.order');
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');

    //
    // hapus transaksi
    Route::get('/hapus-transaksi/{id}', [AdminController::class, 'hapusTransaksi'])->name('hapusTransaksi');
});

Route::prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('index');
    Route::post('/cart/tambah', [KasirController::class, 'tambahCart'])->name('cart.tambah');
    Route::post('/cart/kurangi', [KasirController::class, 'kurangiCart'])->name('cart.kurangi');
    Route::post('/cart/hapus', [KasirController::class, 'hapusCart'])->name('cart.hapus');
    Route::post('/cart/clear', [KasirController::class, 'clearCart'])->name('cart.clear');
    Route::post('/proses', [KasirController::class, 'prosesTransaksi'])->name('proses');

});

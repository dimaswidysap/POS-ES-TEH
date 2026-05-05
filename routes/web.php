<?php

use App\Http\Controllers\AdminController;
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

    //
    Route::get('/order', [AdminController::class, 'order'])->name('admin.order');
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');
});

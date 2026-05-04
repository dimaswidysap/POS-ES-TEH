<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin.index');
    Route::get('/menu', [AdminController::class, 'menu'])->name('admin.menu');
    Route::get('/order', [AdminController::class, 'order'])->name('admin.order');
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');
});

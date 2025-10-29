<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TambahProdukController;
use App\Http\Controllers\StokController;
# tampilan awal dan login
Route::get('/awal', fn() => view('login.awal'))->name('awal');
Route::get('/login', fn() => view('login.login'))->name('login');

# sidebar admin
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/retur', fn() => view('admin.retur'))->name('retur');
Route::get('/admin/laporan', fn() => view('admin.laporan'))->name('laporan');

# Produk routes

// Route dengan parameter harus didefinisikan SEBELUM route tanpa parameter
Route::delete('/admin/tambahproduk/{id}', [TambahProdukController::class, 'destroy'])->name('tambahproduk.destroy')->where('id', '[0-9]+');
Route::get('/admin/tambahproduk', [TambahProdukController::class, 'index'])->name('tambahproduk.index');
Route::post('/admin/tambahproduk', [TambahProdukController::class, 'store'])->name('tambahproduk.store');


#stok routes
Route::get('/admin/stok', [StokController::class, 'index'])->name('stok.index');
Route::get('/admin/stok/create', [StokController::class, 'create'])->name('stok.create');
Route::delete('/admin/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');


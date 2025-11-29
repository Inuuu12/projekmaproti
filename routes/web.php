<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TambahProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TambahCabangController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;

# tampilan awal dan login
Route::get('/awal', fn() => view('login.awal'))->name('awal');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


#company profile routes
Route::get('/company-profile', [CompanyProfileController::class, 'show'])->name('company.profile');


Route::middleware(['auth'])->group(function () {
    Route::middleware('admin')->group(function () {
        # sidebar admin
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        #retur routes (owner actions)
        Route::post('/admin/retur', [ReturController::class, 'store'])->name('retur.store');
        Route::put('/admin/retur/{retur}', [ReturController::class, 'update'])->name('retur.update');
        Route::delete('/admin/retur/{retur}', [ReturController::class, 'destroy'])->name('retur.destroy');

        # Cabang routes
        Route::get('/admin/tambahcabang', [TambahCabangController::class, 'index'])->name('tambahcabang.index');
        Route::post('/admin/tambahcabang', [TambahCabangController::class, 'store'])->name('tambahcabang.store');
        Route::put('/admin/tambahcabang/{id}', [TambahCabangController::class, 'update'])->name('tambahcabang.update');
        Route::delete('/admin/tambahcabang/{id}', [TambahCabangController::class, 'destroy'])->name('tambahcabang.destroy');

        # TambahProduk routes
        Route::delete('/admin/tambahproduk/{id}', [TambahProdukController::class, 'destroy'])->name('tambahproduk.destroy');
        Route::get('/admin/tambahproduk', [TambahProdukController::class, 'index'])->name('tambahproduk.index');
        Route::post('/admin/tambahproduk', [TambahProdukController::class, 'store'])->name('tambahproduk.store');

        #stok routes (owner actions)
        Route::get('/admin/stok/create', [StokController::class, 'create'])->name('stok.create');
        Route::post('/admin/stok', [StokController::class, 'store'])->name('stok.store');
        Route::delete('/admin/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
    });

    Route::middleware('role:owner,superadmin,cabang')->group(function () {
        #kasir routes
        Route::get('/admin/kasir', [KasirController::class, 'index'])->name('admin.kasir');

        # stok view
        Route::get('/admin/stok', [StokController::class, 'index'])->name('stok.index');

        # retur view
        Route::get('/admin/retur', [ReturController::class, 'index'])->name('admin.retur.index');
    });
});
Route::middleware(['auth'])->group(function () {

    // 1. Halaman Kasir
    Route::get('/admin/kasir', [LaporanController::class, 'kasirPage'])->name('admin.kasir');

    // 2. Proses Simpan (Ini yang tadi error "kasir.simpan not defined")
    Route::get('/admin/kasir/simpan', [LaporanController::class, 'simpanDariKasir'])->name('kasir.simpan');

    // 3. Halaman Laporan (Ini yang tadi error "admin.laporan not defined")
    // Kita namakan 'laporan.index' agar standar
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');

    // 3.b Endpoint untuk menerima POST transaksi dari Kasir
    Route::post('/admin/laporan', [LaporanController::class, 'store']);

    // 3.c Export harian (CSV)
    Route::get('/admin/laporan/export-daily', [LaporanController::class, 'exportDaily'])->name('laporan.export.daily');

    // 3.d Download single laporan (CSV)
    Route::get('/admin/laporan/{id}/download', [LaporanController::class, 'download'])->name('laporan.download');

    // 4. Hapus Laporan
    Route::delete('/admin/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/admin/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
});




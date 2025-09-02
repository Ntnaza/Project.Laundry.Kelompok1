<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controller untuk Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\ProfilController as AdminProfilController;
use App\Http\Controllers\Admin\PengaturanController;

// Controller untuk Pelanggan
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\PesananController;
use App\Http\Controllers\Pelanggan\ProfilController as PelangganProfilController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (landing page) akan menampilkan login atau mengarahkan ke dasbor
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('pelanggan.dashboard');
        }
    }
    return view('auth.login');
});

// Route untuk semua fitur autentikasi (Login, Register, dll.)
Auth::routes();


// =====================================================================
// GRUP ROUTE UNTUK ADMIN
// =====================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('paket', PaketController::class);
    Route::resource('diskon', DiskonController::class);
    Route::get('/profil', [AdminProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [AdminProfilController::class, 'update'])->name('profil.update');
    Route::get('/pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/{transaksi}/detail', [TransaksiController::class, 'show'])->name('show');
        Route::post('/{transaksi}/update-status', [TransaksiController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{transaksi}/cetak-invoice', [TransaksiController::class, 'cetakInvoice'])->name('cetakInvoice');
    });

    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/{user}/detail', [PelangganController::class, 'show'])->name('pelanggan.show');

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::post('/cetak', [LaporanController::class, 'cetak'])->name('cetak');
    });
});


// =====================================================================
// GRUP ROUTE UNTUK PELANGGAN
// =====================================================================
Route::middleware(['auth', 'role:pelanggan'])->name('pelanggan.')->group(function () {
    Route::get('/dashboard-pelanggan', [PelangganDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('pesanan')->name('pesanan.')->group(function() {
        Route::get('/baru', [PesananController::class, 'create'])->name('create');
        Route::post('/baru', [PesananController::class, 'store'])->name('store');
        Route::get('/{transaksi}', [PesananController::class, 'show'])->name('show');
    });

    Route::prefix('profil')->name('profil.')->group(function() {
        Route::get('/', [PelangganProfilController::class, 'index'])->name('index');
        Route::put('/', [PelangganProfilController::class, 'update'])->name('update');
    });
});

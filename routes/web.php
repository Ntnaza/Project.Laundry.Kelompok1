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

// Controller untuk Pelanggan
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\PesananController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk semua fitur autentikasi (Login, Register, dll.)
Auth::routes();

// Halaman utama (/)
Route::get('/', function () {
    // Jika pengguna sudah login
    if (Auth::check()) {
        // Cek perannya dan arahkan ke dasbor yang sesuai
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('pelanggan.dashboard');
        }
    }
    // Jika belum login, tampilkan halaman login
    return view('auth.login');
});


// =====================================================================
// GRUP ROUTE UNTUK ADMIN
// =====================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('paket', PaketController::class);
    Route::resource('diskon', DiskonController::class);
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
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/dashboard-pelanggan', [PelangganDashboardController::class, 'index'])->name('pelanggan.dashboard');
    Route::get('/pesan-laundry', [PesananController::class, 'create'])->name('pelanggan.pesanan.create');
    Route::post('/pesan-laundry', [PesananController::class, 'store'])->name('pelanggan.pesanan.store');
});

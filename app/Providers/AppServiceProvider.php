<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // TAMBAHKAN INI
use App\Models\Pengaturan; // TAMBAHKAN INI

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // BAGIAN BARU: BAGIKAN DATA PENGATURAN KE VIEW TERTENTU
        try {
            $pengaturan = Pengaturan::first();
            // Bagikan data ke sidebar admin dan pelanggan
            View::composer(['layouts.partials.sidebar', 'layouts.partials.sidebar_pelanggan'], function ($view) use ($pengaturan) {
                $view->with('pengaturan', $pengaturan);
            });
        } catch (\Exception $e) {
            // Tangani error jika tabel belum ada (saat migrasi awal)
            // Biarkan kosong agar tidak mengganggu proses migrasi
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data ringkasan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menghitung jumlah pesanan yang masuk hari ini
        $pesananHariIni = Transaksi::whereDate('tgl_masuk', Carbon::today())->count();

        // Menghitung total pendapatan bulan ini
        // PERBAIKAN ADA DI BARIS DI BAWAH INI
        $pendapatanBulanIni = Transaksi::whereMonth('tgl_masuk', Carbon::now()->month)
                                     ->whereYear('tgl_masuk', Carbon::now()->year)
                                     ->where('status', 'Diambil')
                                     ->sum('total_bayar'); // Menggunakan kolom 'total_bayar'

        // Menghitung jumlah total pelanggan
        $jumlahPelanggan = User::where('role', 'pelanggan')->count();

        // Menghitung jumlah pesanan yang masih dalam status 'Baru' atau 'Diproses'
        $pesananPerluDiproses = Transaksi::whereIn('status', ['Baru', 'Diproses'])->count();
        
        // Mengambil 5 transaksi terbaru untuk ditampilkan di dashboard
        $transaksiTerbaru = Transaksi::with('pelanggan')->latest()->take(5)->get();

        // Mengirim semua data ke view
        return view('admin.dashboard', compact(
            'pesananHariIni',
            'pendapatanBulanIni',
            'jumlahPelanggan',
            'pesananPerluDiproses',
            'transaksiTerbaru'
        ));
    }
}

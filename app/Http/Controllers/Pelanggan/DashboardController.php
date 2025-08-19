<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi; // PASTIKAN BARIS INI ADA

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor untuk pelanggan.
     */
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Ambil riwayat transaksi milik user tersebut, urutkan dari yang terbaru
        $transaksis = Transaksi::where('pelanggan_id', $user->id)
                               ->latest()
                               ->paginate(5); // Kita batasi 5 per halaman

        // Kirim data user dan transaksinya ke view
        return view('pelanggan.dashboard', compact('user', 'transaksis'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman form untuk filter laporan.
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Memproses data dan mencetak laporan berdasarkan filter.
     */
    public function cetak(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $tgl_mulai = Carbon::parse($request->tgl_mulai)->startOfDay();
        $tgl_akhir = Carbon::parse($request->tgl_akhir)->endOfDay();

        // Ambil data transaksi dalam rentang tanggal yang dipilih
        $laporans = Transaksi::with('pelanggan')
                             ->whereBetween('tgl_masuk', [$tgl_mulai, $tgl_akhir])
                             ->where('status', 'Diambil') // Hanya laporan dari transaksi yang sudah lunas
                             ->get();

        // Hitung total pendapatan dari data yang difilter
        $totalPendapatan = $laporans->sum('total_harga');

        // Data untuk dikirim ke view PDF
        $data = [
            'laporans' => $laporans,
            'tgl_mulai' => $tgl_mulai,
            'tgl_akhir' => $tgl_akhir,
            'totalPendapatan' => $totalPendapatan,
        ];

        // Buat PDF
        $pdf = PDF::loadView('admin.laporan.cetak_pdf', $data);
        
        // Tampilkan atau unduh PDF
        return $pdf->stream('laporan-pendapatan-'.$tgl_mulai->format('d-m-Y').'-'.$tgl_akhir->format('d-m-Y').'.pdf');
    }
}

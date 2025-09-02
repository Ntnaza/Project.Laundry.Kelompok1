<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use PDF; // <-- PASTIKAN BARIS INI ADA

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
     * Memproses filter dan mencetak laporan ke PDF.
     */
    public function cetak(Request $request)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $tgl_mulai = $request->tgl_mulai;
        $tgl_akhir = $request->tgl_akhir;

        // Ambil data transaksi berdasarkan rentang tanggal dan status 'Diambil'
        $transaksis = Transaksi::whereBetween('tgl_masuk', [$tgl_mulai, $tgl_akhir])
                               ->where('status', 'Diambil')
                               ->orderBy('tgl_masuk', 'asc')
                               ->get();
        
        // Hitung total pendapatan dari data yang difilter
        $totalPendapatan = $transaksis->sum('total_bayar');

        $data = [
            'transaksis' => $transaksis,
            'tgl_mulai'  => $tgl_mulai,
            'tgl_akhir'  => $tgl_akhir,
            'totalPendapatan' => $totalPendapatan,
        ];

        // Buat PDF
        $pdf = PDF::loadView('admin.laporan.cetak_pdf', $data);
        
        // Tampilkan atau unduh PDF
        return $pdf->stream('laporan-transaksi-'.$tgl_mulai.'-'.$tgl_akhir.'.pdf');
    }
}


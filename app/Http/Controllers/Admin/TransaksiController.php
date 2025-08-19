<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi; // PASTIKAN BARIS INI ADA
use PDF; // Jika menggunakan library seperti barryvdh/laravel-dompdf

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with('pelanggan')->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pencarian berdasarkan kode transaksi atau nama pelanggan
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('kode_transaksi', 'like', '%' . $request->search . '%')
                  ->orWhereHas('pelanggan', function($subq) use ($request) {
                      $subq->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $transaksis = $query->paginate(10);
        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail lengkap dari sebuah transaksi.
     */
    public function show(Transaksi $transaksi)
    {
        // Eager load detail transaksi beserta info paketnya
        $transaksi->load('details.paket', 'pelanggan');
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Mengupdate status transaksi.
     */
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai,Diambil',
        ]);

        $transaksi->status = $request->status;

        // Jika status diubah menjadi 'Selesai', catat tanggal selesainya
        if ($request->status == 'Selesai') {
            $transaksi->tgl_selesai = now();
        }
        
        $transaksi->save();

        // (Opsional) Kirim notifikasi ke pelanggan di sini

        return redirect()->route('admin.transaksi.show', $transaksi)
                         ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    /**
     * Mencetak invoice dalam format PDF.
     */
    public function cetakInvoice(Transaksi $transaksi)
    {
        $transaksi->load('details.paket', 'pelanggan');
        
        // Contoh menggunakan library barryvdh/laravel-dompdf
        $pdf = PDF::loadView('admin.transaksi.invoice_pdf', compact('transaksi'));
        
        // Tampilkan PDF di browser atau unduh
        return $pdf->stream('invoice-'.$transaksi->kode_transaksi.'.pdf');
    }
}

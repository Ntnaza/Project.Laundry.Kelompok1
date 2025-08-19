<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Diskon; // Import model Diskon
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon untuk tanggal

class PesananController extends Controller
{
    public function create()
    {
        $pakets = Paket::all();
        return view('pelanggan.pesanan.create', compact('pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'kuantitas' => 'required|numeric|min:0.1',
            'kode_diskon' => 'nullable|string|exists:diskons,kode_diskon', // Validasi kode diskon
        ]);

        DB::beginTransaction();
        try {
            $paket = Paket::find($request->paket_id);
            $user = Auth::user();

            $subtotal = $paket->harga * $request->kuantitas;
            $jumlahDiskon = 0;
            $totalBayar = $subtotal;

            // Logika Pengecekan Diskon
            if ($request->kode_diskon) {
                $diskon = Diskon::where('kode_diskon', $request->kode_diskon)->first();
                $hariIni = Carbon::now();

                // Cek apakah diskon valid
                if ($diskon && $hariIni->between($diskon->berlaku_dari, $diskon->berlaku_sampai)) {
                    // Cek minimum belanja
                    if ($subtotal >= $diskon->minimum_belanja) {
                        if ($diskon->tipe == 'persen') {
                            $jumlahDiskon = $subtotal * ($diskon->nilai / 100);
                        } else {
                            $jumlahDiskon = $diskon->nilai;
                        }
                        $totalBayar = $subtotal - $jumlahDiskon;
                    }
                }
            }

            // Buat data di tabel 'transaksis'
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'LD-' . time(),
                'pelanggan_id' => $user->id,
                'subtotal' => $subtotal,
                'jumlah_diskon' => $jumlahDiskon,
                'total_bayar' => $totalBayar,
                'tgl_masuk' => now(),
                'status' => 'Baru',
                'catatan_pelanggan' => $request->catatan,
            ]);

            $transaksi->kode_transaksi = 'LD-' . $transaksi->created_at->format('Ymd') . '-' . sprintf('%04d', $transaksi->id);
            $transaksi->save();

            // Buat data di tabel 'transaksi_details'
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'paket_id' => $paket->id,
                'kuantitas' => $request->kuantitas,
                'subtotal' => $subtotal,
            ]);

            DB::commit();

            return redirect()->route('pelanggan.dashboard')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}

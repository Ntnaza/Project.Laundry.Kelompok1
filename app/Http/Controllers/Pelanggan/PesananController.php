<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'paket_id'    => 'required|exists:pakets,id',
            'kuantitas'   => 'required|numeric|min:0.1',
            'kode_diskon' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $paket = Paket::find($request->paket_id);
            $user = Auth::user();

            $subtotal = $paket->harga * $request->kuantitas;
            $jumlahDiskon = 0;
            
            if ($request->kode_diskon) {
                $diskon = Diskon::where('kode_diskon', $request->kode_diskon)->first();
                $hariIni = now();

                if ($diskon && $hariIni->between($diskon->berlaku_dari, $diskon->berlaku_sampai) && $subtotal >= $diskon->minimum_belanja) {
                    if ($diskon->tipe == 'persen') {
                        $jumlahDiskon = $subtotal * ($diskon->nilai / 100);
                    } else {
                        $jumlahDiskon = $diskon->nilai;
                    }
                } else {
                    return redirect()->back()->with('error', 'Kode diskon tidak valid atau tidak memenuhi syarat.')->withInput();
                }
            }

            $totalBayar = $subtotal - $jumlahDiskon;
            $totalBayar = max(0, $totalBayar);

            // Buat transaksi dengan kode sementara
            $transaksi = Transaksi::create([
                'kode_transaksi'      => 'LD-TEMP-' . time(), // Kode sementara
                'pelanggan_id'        => $user->id,
                'subtotal'            => $subtotal,
                'jumlah_diskon'       => $jumlahDiskon,
                'total_bayar'         => $totalBayar,
                'tgl_masuk'           => now(),
                'status'              => 'Baru',
                'catatan_pelanggan'   => $request->catatan,
            ]);

            // Buat kode transaksi yang unik dan final, lalu simpan
            $transaksi->kode_transaksi = 'LD-' . $transaksi->created_at->format('Ymd') . '-' . sprintf('%04d', $transaksi->id);
            $transaksi->save();

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'paket_id'     => $paket->id,
                'harga'        => $paket->harga,
                'kuantitas'    => $request->kuantitas,
                'subtotal'     => $subtotal,
            ]);
            
            DB::commit();

            return redirect()->route('pelanggan.dashboard')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Transaksi $transaksi)
    {
        if (Auth::id() !== $transaksi->pelanggan_id) {
            abort(403, 'Anda tidak memiliki akses untuk melihat transaksi ini.');
        }
        return view('pelanggan.pesanan.show', compact('transaksi'));
    }
}

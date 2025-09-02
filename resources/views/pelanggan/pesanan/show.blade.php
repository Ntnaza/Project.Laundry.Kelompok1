@extends('layouts.pelanggan')

@section('title', 'Detail Transaksi')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Transaksi: {{ $transaksi->kode_transaksi }}</h1>
    <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Riwayat
    </a>
</div>

<div class="row">
    <!-- Kolom Kiri: Detail Pesanan -->
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th>Jenis</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->details as $detail)
                            <tr>
                                <td>{{ $detail->paket->nama_paket }}</td>
                                <td>{{ $detail->paket->jenis }}</td>
                                <td>{{ number_format($detail->kuantitas, 2) }} {{ $detail->paket->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}</td>
                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($transaksi->catatan_pelanggan)
                <hr>
                <strong>Catatan Pelanggan:</strong>
                <p class="mt-2">{{ $transaksi->catatan_pelanggan }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Rincian & Status -->
    <div class="col-lg-5">
        <!-- Rincian Pembayaran -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Pembayaran</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Subtotal
                        <span>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Diskon
                        <span class="text-danger">- Rp {{ number_format($transaksi->jumlah_diskon, 0, ',', '.') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                        Total Bayar
                        <span class="text-primary h5">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Status & Tanggal -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status & Tanggal</h6>
            </div>
            <div class="card-body">
                <p><strong>Status Saat Ini:</strong> 
                    @if($transaksi->status == 'Baru')
                        <span class="badge badge-primary">{{ $transaksi->status }}</span>
                    @elseif($transaksi->status == 'Diproses')
                        <span class="badge badge-info">{{ $transaksi->status }}</span>
                    @elseif($transaksi->status == 'Selesai')
                        <span class="badge badge-success">{{ $transaksi->status }}</span>
                    @else
                        <span class="badge badge-secondary">{{ $transaksi->status }}</span>
                    @endif
                </p>
                <p><strong>Tanggal Masuk:</strong> {{ $transaksi->tgl_masuk->format('d M Y, H:i') }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $transaksi->tgl_selesai ? $transaksi->tgl_selesai->format('d M Y, H:i') : 'Belum Selesai' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
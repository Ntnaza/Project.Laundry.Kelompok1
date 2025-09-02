@extends('layouts.admin')

@section('title', 'Detail Transaksi ' . $transaksi->kode_transaksi)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Transaksi: {{ $transaksi->kode_transaksi }}</h1>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <!-- Kolom Kiri: Detail Pesanan -->
    <div class="col-md-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->details as $detail)
                            <tr>
                                <td>{{ $detail->paket->nama_paket }}</td>
                                <td>{{ $detail->kuantitas }} {{ $detail->paket->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}</td>
                                <td>Rp {{ number_format($detail->paket->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Subtotal:</th>
                                <th>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Diskon:</th>
                                <th>- Rp {{ number_format($transaksi->jumlah_diskon, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-right">Total Bayar:</th>
                                <th class="text-primary">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Info Pelanggan & Status -->
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Pelanggan</h6>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $transaksi->pelanggan->name }}</p>
                <p><strong>Email:</strong> {{ $transaksi->pelanggan->email }}</p>
                <p><strong>No. HP:</strong> {{ $transaksi->pelanggan->no_hp }}</p>
                <p><strong>Alamat:</strong> {{ $transaksi->pelanggan->alamat }}</p>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status & Aksi</h6>
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
                <p><strong>Tanggal Masuk:</strong> {{ $transaksi->tgl_masuk->format('d F Y') }}</p>
                <p><strong>Tanggal Selesai:</strong> {{ $transaksi->tgl_selesai ? $transaksi->tgl_selesai->format('d F Y') : 'Belum Selesai' }}</p>
                <hr>
                <form action="{{ route('admin.transaksi.updateStatus', $transaksi->id) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="form-group">
                        <label for="status">Ubah Status Menjadi:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Diproses" {{ $transaksi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $transaksi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Diambil" {{ $transaksi->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-block">Update Status</button>
                </form>
                <a href="{{ route('admin.transaksi.cetakInvoice', $transaksi->id) }}" target="_blank" class="btn btn-success btn-block">
                    <i class="fa fa-print"></i> Cetak Invoice
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
        
@extends('layouts.pelanggan')

@section('title', 'Dasbor Pelanggan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dasbor</h1>
</div>

{{-- Tampilkan pesan sukses jika ada --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, {{ Auth::user()->name }}!</h6>
            </div>
            <div class="card-body">
                <p>Ini adalah halaman dasbor Anda. Dari sini Anda bisa membuat pesanan baru dan melacak status cucian Anda.</p>
                <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pesanan Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Riwayat Pesanan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pesanan Anda</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode Transaksi</th>
                        <th>Tanggal Pesan</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th> {{-- KOLOM BARU --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->kode_transaksi }}</td>
                            <td>{{ $transaksi->tgl_masuk->format('d M Y') }}</td>
                            <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                @if($transaksi->status == 'Baru')
                                    <span class="badge badge-primary">{{ $transaksi->status }}</span>
                                @elseif($transaksi->status == 'Diproses')
                                    <span class="badge badge-info">{{ $transaksi->status }}</span>
                                @elseif($transaksi->status == 'Selesai')
                                    <span class="badge badge-success">{{ $transaksi->status }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $transaksi->status }}</span>
                                @endif
                            </td>
                            {{-- TOMBOL BARU --}}
                            <td>
                                <a href="{{ route('pelanggan.pesanan.show', $transaksi->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Sesuaikan colspan menjadi 5 --}}
                            <td colspan="5" class="text-center">Anda belum memiliki riwayat pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Menampilkan Paginasi --}}
        <div class="d-flex justify-content-center">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection


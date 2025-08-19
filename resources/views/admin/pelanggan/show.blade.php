@extends('layouts.admin')

@section('title', 'Detail Pelanggan: ' . $user->name)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pelanggan</h1>
    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Kolom Kiri: Profil Pelanggan -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Profil: {{ $user->name }}</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-profile rounded-circle mb-3" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=100&background=random" alt="Profile Picture">
                </div>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>No. HP:</strong> {{ $user->no_hp }}</p>
                <p><strong>Alamat:</strong></p>
                <p>{{ $user->alamat }}</p>
                <p><strong>Terdaftar Sejak:</strong> {{ $user->created_at->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Riwayat Transaksi -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Tanggal Masuk</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->tgl_masuk->format('d M Y') }}</td>
                                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
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
                                <td>
                                    <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Pelanggan ini belum pernah melakukan transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

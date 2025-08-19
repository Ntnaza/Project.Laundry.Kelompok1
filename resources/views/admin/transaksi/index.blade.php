@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Transaksi</h1>
</div>

<!-- Filter and Search Form -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.transaksi.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-3 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Cari Kode/Nama..." value="{{ request('search') }}">
            </div>
            <div class="form-group mr-3 mb-2">
                <select name="status" class="form-control">
                    <option value="">-- Semua Status --</option>
                    <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Diambil" {{ request('status') == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Filter</button>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
        </form>
    </div>
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Masuk</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $transaksis->firstItem() + $index }}</td>
                            <td>{{ $transaksi->kode_transaksi }}</td>
                            <td>{{ $transaksi->pelanggan->name ?? 'N/A' }}</td>
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
                                <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data transaksi tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Tampilkan Paginasi -->
        <div class="d-flex justify-content-center">
            {{ $transaksis->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

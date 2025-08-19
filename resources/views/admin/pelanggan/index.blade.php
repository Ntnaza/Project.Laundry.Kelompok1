@extends('layouts.admin')

@section('title', 'Data Pelanggan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1>
</div>

<!-- Search Form -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.pelanggan.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-3 mb-2">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama/Email/No. HP..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Cari</button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
        </form>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $index => $pelanggan)
                        <tr>
                            <td>{{ $pelanggans->firstItem() + $index }}</td>
                            <td>{{ $pelanggan->name }}</td>
                            <td>{{ $pelanggan->email }}</td>
                            <td>{{ $pelanggan->no_hp }}</td>
                            <td>{{ Str::limit($pelanggan->alamat, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.pelanggan.show', $pelanggan->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data pelanggan tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Tampilkan Paginasi -->
        <div class="d-flex justify-content-center">
            {{ $pelanggans->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

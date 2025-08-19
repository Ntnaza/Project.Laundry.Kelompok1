@extends('layouts.admin')

@section('title', 'Manajemen Diskon')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Diskon</h1>
    <a href="{{ route('admin.diskon.create') }}" class="btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Diskon Baru
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Diskon Aktif & Kadaluarsa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Nilai</th>
                        <th>Min. Belanja</th>
                        <th>Berlaku Sampai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($diskons as $index => $diskon)
                        <tr>
                            <td>{{ $diskons->firstItem() + $index }}</td>
                            <td>{{ $diskon->kode_diskon }}</td>
                            <td>{{ $diskon->keterangan }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($diskon->tipe) }}</span></td>
                            <td>
                                @if($diskon->tipe == 'persen')
                                    {{ $diskon->nilai }}%
                                @else
                                    Rp {{ number_format($diskon->nilai, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($diskon->minimum_belanja, 0, ',', '.') }}</td>
                            <td>{{ $diskon->berlaku_sampai->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.diskon.edit', $diskon->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('admin.diskon.destroy', $diskon->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus diskon ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data diskon.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $diskons->links() }}
        </div>
    </div>
</div>
@endsection

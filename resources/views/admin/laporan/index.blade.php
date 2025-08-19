@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
</div>

<!-- Tampilkan jika ada error validasi -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Berdasarkan Tanggal</h6>
    </div>
    <div class="card-body">
        <p>Pilih rentang tanggal untuk mencetak laporan transaksi yang sudah selesai (status "Diambil").</p>
        <form action="{{ route('admin.laporan.cetak') }}" method="POST" target="_blank">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="tgl_mulai">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ old('tgl_mulai', date('Y-m-01')) }}" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="{{ old('tgl_akhir', date('Y-m-d')) }}" required>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

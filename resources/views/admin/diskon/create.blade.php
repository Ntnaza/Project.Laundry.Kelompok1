@extends('layouts.admin')

@section('title', 'Tambah Diskon Baru')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Diskon Baru</h1>
    <a href="{{ route('admin.diskon.index') }}" class="btn btn-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
</div>

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
    <div class="card-body">
        <form action="{{ route('admin.diskon.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kode_diskon">Kode Diskon</label>
                <input type="text" name="kode_diskon" class="form-control" value="{{ old('kode_diskon') }}" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tipe">Tipe Diskon</label>
                    <select name="tipe" class="form-control" required>
                        <option value="persen" {{ old('tipe') == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                        <option value="nominal" {{ old('tipe') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="nilai">Nilai</label>
                    <input type="number" name="nilai" class="form-control" value="{{ old('nilai') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="minimum_belanja">Minimum Belanja (Rp)</label>
                <input type="number" name="minimum_belanja" class="form-control" value="{{ old('minimum_belanja', 0) }}" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="berlaku_dari">Berlaku Dari</label>
                    <input type="date" name="berlaku_dari" class="form-control" value="{{ old('berlaku_dari') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="berlaku_sampai">Berlaku Sampai</label>
                    <input type="date" name="berlaku_sampai" class="form-control" value="{{ old('berlaku_sampai') }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection

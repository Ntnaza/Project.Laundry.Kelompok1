@extends('layouts.admin')

@section('title', 'Edit Paket Laundry')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Paket: {{ $paket->nama_paket }}</h1>
    <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary btn-sm">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
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
    <div class="card-body">
        <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_paket">Nama Paket</label>
                <input type="text" name="nama_paket" id="nama_paket" class="form-control" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
            </div>
            <div class="form-group">
                <label for="jenis">Jenis Paket</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Kiloan" {{ old('jenis', $paket->jenis) == 'Kiloan' ? 'selected' : '' }}>Kiloan</option>
                    <option value="Satuan" {{ old('jenis', $paket->jenis) == 'Satuan' ? 'selected' : '' }}>Satuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga', $paket->harga) }}" required>
            </div>
            <div class="form-group">
                <label for="estimasi_hari">Estimasi Selesai (Hari)</label>
                <input type="number" name="estimasi_hari" id="estimasi_hari" class="form-control" value="{{ old('estimasi_hari', $paket->estimasi_hari) }}" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                Update
            </button>
        </form>
    </div>
</div>
@endsection

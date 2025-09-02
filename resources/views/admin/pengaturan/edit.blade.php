@extends('layouts.admin')

@section('title', 'Profil Laundry')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Laundry</h1>
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

{{-- Tampilkan pesan error validasi jika ada --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-lg-4">
        <!-- Kartu untuk menampilkan logo -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Logo Laundry</h6>
            </div>
            <div class="card-body text-center">
                @if ($pengaturan->logo)
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;" src="{{ asset('storage/' . $pengaturan->logo) }}" alt="Logo Laundry">
                @else
                    <div class="text-center">
                        <i class="fas fa-store fa-5x text-gray-300"></i>
                        <p class="mt-2">Belum ada logo</p>
                    </div>
                @endif
                <h5 class="font-weight-bold mt-2">{{ $pengaturan->nama_laundry }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <!-- Kartu Form Edit Pengaturan -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Informasi</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="nama_laundry" class="col-sm-3 col-form-label">Nama Laundry</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_laundry" name="nama_laundry" value="{{ old('nama_laundry', $pengaturan->nama_laundry) }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $pengaturan->alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $pengaturan->no_hp) }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="logo" class="col-sm-3 col-form-label">Ganti Logo</label>
                        <div class="col-sm-9">
                             <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                <label class="custom-file-label" for="logo">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti logo. Maksimal 2MB.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Skrip untuk menampilkan nama file di input -->
<script>
document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("logo").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
})
</script>
@endpush

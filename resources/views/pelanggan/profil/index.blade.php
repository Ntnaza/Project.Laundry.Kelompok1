@extends('layouts.pelanggan')

@section('title', 'Profil Saya')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
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
        <!-- BARU: Kartu untuk menampilkan foto profil -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foto Profil</h6>
            </div>
            <div class="card-body text-center">
                @if (Auth::user()->foto_profil)
                    <img class="img-profile rounded-circle mb-3" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Foto Profil" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                     <img class="img-profile rounded-circle mb-3" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&size=150" alt="Foto Profil">
                @endif
                <h5 class="font-weight-bold">{{ Auth::user()->name }}</h5>
                <p>{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <!-- Kartu Form Edit Profil -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
            </div>
            <div class="card-body">
                <!-- BARU: Tambahkan enctype untuk upload file -->
                <form method="POST" action="{{ route('pelanggan.profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Alamat Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_hp" class="col-sm-3 col-form-label">Nomor HP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label">Alamat Lengkap</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>

                    <!-- BARU: Form group untuk input file foto -->
                    <div class="form-group row">
                        <label for="foto_profil" class="col-sm-3 col-form-label">Ganti Foto</label>
                        <div class="col-sm-9">
                             <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_profil" name="foto_profil">
                                <label class="custom-file-label" for="foto_profil">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto. Maksimal 2MB.</small>
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
<!-- BARU: Skrip untuk menampilkan nama file di input -->
<script>
document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("foto_profil").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
})
</script>
@endpush


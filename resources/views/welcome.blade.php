@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="p-5 mb-4 bg-light rounded-3 text-center">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Selamat Datang di Laundry Anda</h1>
                    <p class="fs-4">Solusi laundry cepat, bersih, dan terpercaya. Silakan masuk atau daftar untuk mulai memesan.</p>
                    
                    <hr class="my-4">
                    
                    @guest
                        @if (Route::has('login'))
                            <a class="btn btn-primary btn-lg mx-2" href="{{ route('login') }}">Login</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="btn btn-success btn-lg mx-2" href="{{ route('register') }}">Daftar Sekarang</a>
                        @endif
                    @else
                        <p>Anda sudah login. Silakan menuju dasbor Anda.</p>
                        {{-- PERBAIKAN ADA DI BARIS DI BAWAH INI --}}
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">Masuk ke Dasbor Admin</a>
                        @else
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-primary btn-lg">Masuk ke Dasbor Pelanggan</a>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

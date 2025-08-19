@extends('layouts.pelanggan')

@section('title', 'Buat Pesanan Baru')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Pesanan Laundry Baru</h1>
</div>

<div class="row">
    <div class="col-lg-10">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Pemesanan</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pelanggan.pesanan.store') }}">
                    @csrf

                    {{-- Baris untuk Pilih Paket --}}
                    <div class="form-group row">
                        <label for="paket_id" class="col-sm-3 col-form-label">{{ __('Pilih Paket Laundry') }}</label>
                        <div class="col-sm-9">
                            <select id="paket_id" name="paket_id" class="form-control @error('paket_id') is-invalid @enderror" required>
                                <option value="">-- Silakan Pilih Paket --</option>
                                @foreach ($pakets as $paket)
                                    <option value="{{ $paket->id }}" data-harga="{{ $paket->harga }}" data-jenis="{{ $paket->jenis }}">
                                        {{ $paket->nama_paket }} - (Rp {{ number_format($paket->harga) }}/{{ $paket->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('paket_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris untuk Kuantitas --}}
                    <div class="form-group row">
                        <label for="kuantitas" class="col-sm-3 col-form-label">{{ __('Kuantitas') }}</label>
                        <div class="col-sm-9">
                            <input id="kuantitas" type="number" step="0.1" class="form-control @error('kuantitas') is-invalid @enderror" name="kuantitas" value="{{ old('kuantitas') }}" required placeholder="Contoh: 5.5">
                            <small id="unit" class="form-text text-muted">Masukkan jumlah (Kg/Pcs)</small>
                            @error('kuantitas')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- BARIS BARU UNTUK KODE DISKON --}}
                    <div class="form-group row">
                        <label for="kode_diskon" class="col-sm-3 col-form-label">{{ __('Kode Diskon (Opsional)') }}</label>
                        <div class="col-sm-9">
                            <input id="kode_diskon" type="text" class="form-control @error('kode_diskon') is-invalid @enderror" name="kode_diskon" value="{{ old('kode_diskon') }}" placeholder="Masukkan kode diskon jika ada">
                             @error('kode_diskon')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris untuk Catatan --}}
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-3 col-form-label">{{ __('Catatan (Opsional)') }}</label>
                        <div class="col-sm-9">
                            <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Contoh: Jangan pakai pelembut">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <hr>
                    
                    {{-- TAMPILAN BARU UNTUK RINCIAN HARGA --}}
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <h5 class="font-weight-bold">Rincian Harga:</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-right" id="subtotal">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td class="text-right" id="diskon">Rp 0</td>
                                </tr>
                                <tr>
                                    <th class="h4">Total Bayar</th>
                                    <th class="text-right h4 text-primary" id="total_bayar">Rp 0</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Baris untuk Tombol --}}
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Konfirmasi Pesanan') }}
                            </button>
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- SCRIPT INI TIDAK PERLU DIUBAH KARENA PERHITUNGAN AKAN DILAKUKAN DI BACKEND --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paketSelect = document.getElementById('paket_id');
    const kuantitasInput = document.getElementById('kuantitas');
    const subtotalEl = document.getElementById('subtotal');
    const totalBayarEl = document.getElementById('total_bayar');
    const unitEl = document.getElementById('unit');

    function hitungEstimasi() {
        const selectedOption = paketSelect.options[paketSelect.selectedIndex];
        if (!selectedOption || !selectedOption.getAttribute('data-harga')) {
            subtotalEl.textContent = 'Rp 0';
            totalBayarEl.textContent = 'Rp 0';
            unitEl.textContent = 'Masukkan jumlah (Kg/Pcs)';
            return;
        }
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const kuantitas = parseFloat(kuantitasInput.value) || 0;
        const jenis = selectedOption.getAttribute('data-jenis');

        if(jenis) {
            unitEl.textContent = `Masukkan jumlah dalam satuan ${jenis}`;
        } else {
            unitEl.textContent = 'Masukkan jumlah (Kg/Pcs)';
        }

        const subtotal = harga * kuantitas;
        
        subtotalEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        totalBayarEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal); // Tampilkan subtotal sebagai total sementara
    }

    paketSelect.addEventListener('change', hitungEstimasi);
    kuantitasInput.addEventListener('input', hitungEstimasi);
});
</script>
@endpush

@extends('layouts.pelanggan')

@section('title', 'Pembayaran Pesanan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pembayaran Pesanan: {{ $transaksi->kode_transaksi }}</h1>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian Pesanan</h6>
            </div>
            <div class="card-body">
                <p>Silakan selesaikan pembayaran Anda untuk melanjutkan proses laundry.</p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Subtotal</th>
                            <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Diskon</th>
                            <td class="text-danger">- Rp {{ number_format($transaksi->jumlah_diskon, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="h4">Total Bayar</th>
                            <td class="h4 font-weight-bold">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <button id="pay-button" class="btn btn-primary btn-lg btn-block">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script untuk Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken Diambil dari controller
        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result){
                /* Anda bisa menambahkan logika di sini jika pembayaran sukses, 
                   misalnya, mengirim data ke server Anda via AJAX. */
                console.log(result);
                window.location.href = "{{ route('pelanggan.pesanan.show', $transaksi->id) }}?payment_success=true";
            },
            // Optional
            onPending: function(result){
                /* Anda bisa menambahkan logika di sini jika pembayaran pending */
                console.log(result);
                window.location.href = "{{ route('pelanggan.pesanan.show', $transaksi->id) }}?payment_pending=true";
            },
            // Optional
            onError: function(result){
                /* Anda bisa menambahkan logika di sini jika pembayaran gagal */
                console.log(result);
                alert("Pembayaran gagal. Silakan coba lagi.");
            }
        });
    };
</script>
@endpush

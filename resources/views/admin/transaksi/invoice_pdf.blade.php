<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $transaksi->kode_transaksi }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .header, .footer { text-align: center; }
        .header h1 { margin: 0; }
        .header p { margin: 0; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .invoice-details { margin-bottom: 20px; }
        .invoice-details table { width: auto; }
        .invoice-details td { border: none; padding: 2px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <table style="width:100%; border:none;">
            <tr>
                <td style="width:60%; border:none;">
                    <h2>LAUNDRY ANDA</h2>
                    <p>Jalan Kenangan No. 123, Kota Bahagia</p>
                    <p>Telepon: 0812-3456-7890</p>
                </td>
                <td style="width:40%; border:none; text-align:right;">
                    <h1>INVOICE</h1>
                    <p><strong>No:</strong> {{ $transaksi->kode_transaksi }}</p>
                </td>
            </tr>
        </table>
        
        <hr>

        <div class="invoice-details">
            <table>
                <tr>
                    <td><strong>Kepada Yth:</strong></td>
                    <td>{{ $transaksi->pelanggan->name }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Masuk:</strong></td>
                    <td>{{ $transaksi->tgl_masuk->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Selesai:</strong></td>
                    <td>{{ $transaksi->tgl_selesai ? $transaksi->tgl_selesai->format('d F Y') : '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Kuantitas</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->paket->nama_paket }}</td>
                        <td>{{ $detail->kuantitas }} {{ $detail->paket->jenis == 'Kiloan' ? 'Kg' : 'Pcs' }}</td>
                        <td class="text-right">Rp {{ number_format($detail->paket->harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">GRAND TOTAL</th>
                        <th class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer" style="margin-top: 40px;">
            <p>Terima kasih telah menggunakan jasa kami.</p>
            <p><i>Harap simpan invoice ini sebagai bukti pembayaran yang sah.</i></p>
        </div>
    </div>
</body>
</html>

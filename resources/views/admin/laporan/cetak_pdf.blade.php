<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan</title>
    <style>
        body { 
            font-family: 'Helvetica', sans-serif; 
            font-size: 12px; 
            color: #333;
        }
        .container { 
            width: 100%; 
            margin: 0 auto; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px;
        }
        .header h1 { 
            margin: 0; 
            font-size: 24px;
        }
        .header p { 
            margin: 2px 0; 
            font-size: 14px;
        }
        .content { 
            margin-top: 20px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 8px; 
            text-align: left;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .text-right { 
            text-align: right; 
        }
        .total-row th {
            font-size: 14px;
            background-color: #e8e8e8;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Pendapatan</h1>
            <p><strong>LAUNDRY ANDA</strong></p>
            <p>Periode: {{ $tgl_mulai->format('d F Y') }} - {{ $tgl_akhir->format('d F Y') }}</p>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Masuk</th>
                        <th class="text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $index => $laporan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $laporan->kode_transaksi }}</td>
                        <td>{{ $laporan->pelanggan->name ?? 'N/A' }}</td>
                        <td>{{ $laporan->tgl_masuk->format('d M Y') }}</td>
                        <td class="text-right">Rp {{ number_format($laporan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data transaksi yang selesai pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <th colspan="4" class="text-right">TOTAL PENDAPATAN</th>
                        <th class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh sistem pada tanggal {{ date('d F Y H:i') }}.</p>
        </div>
    </div>
</body>
</html>

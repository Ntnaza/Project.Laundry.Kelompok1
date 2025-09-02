<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2 { text-align: center; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Laporan Transaksi Laundry</h1>
    <h2>Periode: {{ \Carbon\Carbon::parse($tgl_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tgl_akhir)->format('d F Y') }}</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Tanggal Masuk</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $transaksi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaksi->kode_transaksi }}</td>
                <td>{{ $transaksi->pelanggan->name }}</td>
                <td>{{ \Carbon\Carbon::parse($transaksi->tgl_masuk)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total" style="text-align: right;">Total Pendapatan:</td>
                <td class="total">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

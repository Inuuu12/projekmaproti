<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    <style>
        .header { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; font-weight: bold; text-align: center; }
        .subheader { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 11px; text-align: center; color: #555; }
        th { background-color: #151D29; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 11px; font-weight: bold; text-align: center; border: 0.5pt solid #ccc; }
        td { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 11px; border: 0.5pt solid #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .num-format { mso-number-format:"\#\,\#\#0"; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="4" class="header">LAPORAN TRANSAKSI PENJUALAN</td>
        </tr>
        <tr>
            <td colspan="4" class="subheader">La Fleur a Tory - Cabang Pusat & Seluruh Cabang</td>
        </tr>
        <tr>
            <td colspan="4" class="subheader">Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <thead>
            <tr>
                <th style="width: 80px;">No</th>
                <th style="width: 150px;">Tanggal</th>
                <th style="width: 450px;">Rincian Penjualan</th>
                <th style="width: 150px;">Total Transaksi (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($laporans as $i => $lap)
                @php
                    $totalTransaksi = 0;
                    if ($lap->deskripsi) {
                        $details = json_decode($lap->deskripsi, true);
                        if (is_array($details)) {
                            foreach($details as $d) {
                                $totalTransaksi += ($d['qty'] ?? 0) * ($d['harga'] ?? 0);
                            }
                        }
                    }
                    $grandTotal += $totalTransaksi;
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($lap->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        {{ $lap->judul }}
                    </td>
                    <td class="text-right num-format">{{ $totalTransaksi }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td colspan="3" class="text-right">GRAND TOTAL</td>
                <td class="text-right num-format">{{ $grandTotal }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    <style>
        .header { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; font-weight: bold; }
        .subheader { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 10px; color: #666; }
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
            <td colspan="6" class="header">LAPORAN RINCIAN TRANSAKSI PENJUALAN</td>
        </tr>
        <tr>
            <td colspan="6" class="subheader">La Fleur a Tory</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td><strong>ID Laporan:</strong></td>
            <td>#{{ $lap->id }}</td>
            <td colspan="2"></td>
            <td><strong>Tanggal:</strong></td>
            <td>{{ \Carbon\Carbon::parse($lap->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Dibuat Oleh:</strong></td>
            <td>{{ $lap->user->username ?? '-' }}</td>
            <td colspan="2"></td>
            <td><strong>Waktu Ekspor:</strong></td>
            <td>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Judul Ringkasan:</strong></td>
            <td colspan="5">{{ $lap->judul }}</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 250px;">Nama Produk</th>
                <th style="width: 150px;">Cabang</th>
                <th style="width: 120px;">Harga Satuan (Rp)</th>
                <th style="width: 80px;">Jumlah</th>
                <th style="width: 150px;">Total Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
                $details = [];
                if ($lap->deskripsi) {
                    $details = json_decode($lap->deskripsi, true);
                }
            @endphp
            @foreach($details as $i => $d)
                @php
                    $subTotal = ($d['qty'] ?? 0) * ($d['harga'] ?? 0);
                    $grandTotal += $subTotal;
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $d['nama'] ?? '-' }}</td>
                    <td class="text-center">{{ $d['cabang'] ?? '-' }}</td>
                    <td class="text-right num-format">{{ $d['harga'] ?? 0 }}</td>
                    <td class="text-center">{{ $d['qty'] ?? 0 }} pcs</td>
                    <td class="text-right num-format" style="font-weight: bold;">{{ $subTotal }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="5" class="text-right">TOTAL TRANSAKSI</td>
                <td class="text-right num-format">{{ $grandTotal }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>

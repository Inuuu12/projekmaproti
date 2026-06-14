<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Penjualan - #{{ $lap->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.5; }
        .invoice-card { background: #fff; padding: 10px; }
        .header { border-bottom: 2px solid #151D29; padding-bottom: 12px; margin-bottom: 15px; }
        .header-title { font-size: 16px; font-weight: bold; color: #151D29; text-transform: uppercase; margin: 0; }
        .company-name { font-size: 12px; font-weight: bold; margin-top: 4px; }
        .company-details { color: #666; font-size: 9px; margin-top: 2px; }
        .report-meta { margin-bottom: 15px; }
        .report-meta table { width: 100%; border: none; margin: 0; }
        .report-meta td { border: none; padding: 3px 0; font-size: 10px; }
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th, .main-table td { border: 1px solid #e2e8f0; padding: 8px; }
        .main-table th { background-color: #f8fafc; font-weight: bold; color: #475569; font-size: 9px; text-transform: uppercase; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 40px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="invoice-card">
        <div class="header">
            <div class="header-title">Laporan Rincian Transaksi</div>
            <div class="company-name">La Fleur a Tory</div>
            <div class="company-details">Sistem Penjualan Terintegrasi</div>
        </div>

        <div class="report-meta">
            <table>
                <tr>
                    <td style="width: 20%;"><strong>ID Laporan:</strong></td>
                    <td style="width: 30%;">#{{ $lap->id }}</td>
                    <td style="width: 20%;"><strong>Tanggal Penjualan:</strong></td>
                    <td style="width: 30%;">{{ \Carbon\Carbon::parse($lap->tanggal)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Dibuat Oleh:</strong></td>
                    <td>{{ $lap->user->username ?? '-' }}</td>
                    <td><strong>Waktu Ekspor:</strong></td>
                    <td>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Deskripsi Ringkas:</strong></td>
                    <td colspan="3">{{ $lap->judul }}</td>
                </tr>
            </table>
        </div>

        <h3 style="font-size: 12px; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 8px;">Rincian Item Terjual</h3>
        <table class="main-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 8%;">No</th>
                    <th>Nama Produk</th>
                    <th class="text-center" style="width: 20%;">Cabang</th>
                    <th class="text-right" style="width: 20%;">Harga Satuan</th>
                    <th class="text-center" style="width: 12%;">Jumlah</th>
                    <th class="text-right" style="width: 20%;">Total Harga</th>
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
                @forelse($details as $i => $d)
                    @php
                        $subTotal = ($d['qty'] ?? 0) * ($d['harga'] ?? 0);
                        $grandTotal += $subTotal;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td><strong>{{ $d['nama'] ?? '-' }}</strong></td>
                        <td class="text-center">{{ $d['cabang'] ?? '-' }}</td>
                        <td class="text-right">Rp{{ number_format($d['harga'] ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $d['qty'] ?? 0 }} pcs</td>
                        <td class="text-right" style="font-weight: bold; color: #1e293b;">Rp{{ number_format($subTotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color: #64748b; padding: 20px;">Tidak ada rincian item transaksi untuk laporan ini.</td>
                    </tr>
                @endforelse
                @if(count($details) > 0)
                    <tr style="background-color: #f8fafc; font-weight: bold;">
                        <td colspan="5" class="text-right" style="font-size: 10px; text-transform: uppercase;">Total Transaksi</td>
                        <td class="text-right" style="font-size: 11px; color: #151D29;">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="footer">
            <p>Laporan ini sah dan dihasilkan secara resmi oleh sistem point of sales La Fleur a Tory.</p>
        </div>
    </div>
</body>
</html>

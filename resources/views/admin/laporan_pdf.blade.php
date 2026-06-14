<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Penjualan</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #151D29; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; color: #151D29; text-transform: uppercase; }
        .header p { margin: 4px 0 0 0; color: #666; font-size: 10px; }
        .meta-info { margin-bottom: 15px; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; color: #475569; font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Transaksi Penjualan</h1>
        <p>La Fleur a Tory - Cabang Pusat & Seluruh Cabang</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y H:i') }}</p>
    </div>

    <div class="meta-info">
        <strong>Status Laporan:</strong> Resmi / Terkomputerisasi
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 60%;">Rincian Penjualan</th>
                <th style="width: 20%;" class="text-right">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($laporans as $i => $lap)
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
                    <td>{{ \Carbon\Carbon::parse($lap->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        <strong style="color: #1e293b;">{{ $lap->judul }}</strong>
                        @if($lap->deskripsi)
                            <div style="font-size: 9px; color: #64748b; margin-top: 4px;">
                                @php
                                    $details = json_decode($lap->deskripsi, true);
                                @endphp
                                @if(is_array($details))
                                    <table style="width: 100%; margin: 5px 0 0 0; border: none;">
                                        @foreach($details as $d)
                                            <tr style="background: none;">
                                                <td style="border: none; padding: 1px 0; font-size: 9px; color: #64748b;">
                                                    • {{ $d['nama'] ?? '-' }} ({{ $d['qty'] ?? 0 }} pcs) @ Rp{{ number_format($d['harga'] ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td style="border: none; padding: 1px 0; font-size: 9px; color: #64748b;" class="text-right">
                                                    Rp{{ number_format(($d['qty'] ?? 0) * ($d['harga'] ?? 0), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="text-right" style="font-weight: bold; color: #1e293b;">
                        Rp{{ number_format($totalTransaksi, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center" style="padding: 20px; color: #64748b;">Belum ada data laporan</td>
                </tr>
            @endforelse
            @if($laporans->count() > 0)
                <tr style="background-color: #f1f5f9; font-weight: bold;">
                    <td colspan="3" class="text-right" style="padding: 10px; font-size: 10px; text-transform: uppercase;">Grand Total</td>
                    <td class="text-right" style="padding: 10px; font-size: 11px; color: #151D29;">
                        Rp{{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh sistem point of sales La Fleur a Tory.</p>
    </div>
</body>
</html>

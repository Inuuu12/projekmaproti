<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Laporan;
use App\Models\Stok;
use App\Models\Retur;
use App\Models\Cabang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tz = 'Asia/Jakarta';
        $today = Carbon::now($tz)->format('Y-m-d');

        // Penjualan Hari Ini (jumlah Rupiah)
        $laporansToday = Laporan::whereDate('tanggal', $today)->get();
        $penjualanToday = 0;
        foreach ($laporansToday as $lap) {
            if ($lap->deskripsi) {
                $decoded = json_decode($lap->deskripsi, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $d) {
                        $qty = isset($d['qty']) ? intval($d['qty']) : 0;
                        $harga = isset($d['harga']) ? floatval($d['harga']) : 0;
                        $penjualanToday += ($qty * $harga);
                    }
                    continue;
                }
            }
            // Fallback: coba ambil dari judul (jika ada "Total Rp ...")
            if (preg_match('/Total Rp\s*([0-9\.,]+)/u', $lap->judul ?? '', $m)) {
                $num = preg_replace('/[^0-9]/', '', $m[1]);
                $penjualanToday += intval($num);
            }
        }

        // Total stok roti (hanya yang belum kadaluarsa)
        $totalStok = Stok::where('stok', '>', 0)
            ->where(function ($q) use ($today) {
                $q->whereNull('tanggal_kadaluarsa')->orWhereDate('tanggal_kadaluarsa', '>', $today);
            })->sum('stok');

        // Perlu retur: hitung dari tabel `returs` untuk hari ini (otomatis ter-update jika record retur dihapus)
        $perluRetur = Retur::whereDate('tanggal_retur', $today)->sum('jumlah');

        // Total cabang
        $totalCabang = Cabang::count();

        // Tren penjualan mingguan (7 hari termasuk hari ini)
        $labelsWeek = [];
        $dataWeek = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::now($tz)->subDays($i)->format('Y-m-d');
            $dt = Carbon::parse($d);
            // Map ISO weekday (1=Mon .. 7=Sun) to Indonesian short names
            $shortDays = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
            $labelsWeek[] = $shortDays[$dt->isoWeekday() - 1];

            $lap = Laporan::whereDate('tanggal', $d)->get();
            $sumDay = 0;
            foreach ($lap as $l) {
                if ($l->deskripsi) {
                    $decoded = json_decode($l->deskripsi, true);
                    if (is_array($decoded)) {
                        foreach ($decoded as $dd) {
                            $sumDay += (intval($dd['qty'] ?? 0) * floatval($dd['harga'] ?? 0));
                        }
                    }
                } else {
                    if (preg_match('/Total Rp\s*([0-9\.,]+)/u', $l->judul ?? '', $m)) {
                        $num = preg_replace('/[^0-9]/', '', $m[1]);
                        $sumDay += intval($num);
                    }
                }
            }
            // gunakan nilai dalam ribuan agar cocok dengan label sebelumnya
            $dataWeek[] = round($sumDay / 1000); // ribuan
        }

        // Distribusi stok per cabang (gunakan semua cabang, default 0)
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $labelsCabang = [];
        $dataCabang = [];
        foreach ($cabangs as $c) {
            $labelsCabang[] = $c->nama_cabang;
            $sum = Stok::where('cabang', $c->nama_cabang)
                ->where('stok', '>', 0)
                ->where(function ($q) use ($today) {
                    $q->whereNull('tanggal_kadaluarsa')->orWhereDate('tanggal_kadaluarsa', '>', $today);
                })->sum('stok');
            $dataCabang[] = $sum;
        }

        return view('admin.dashboard', compact(
            'penjualanToday', 'totalStok', 'perluRetur', 'totalCabang',
            'labelsWeek', 'dataWeek', 'labelsCabang', 'dataCabang'
        ));
    }
}

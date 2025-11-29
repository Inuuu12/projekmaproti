<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Produk;
use App\Models\Cabang;
use App\Models\Stok;
use App\Models\Retur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // IMPORT LIBRARY PDF

class LaporanController extends Controller
{
    // 1. Tampilkan Halaman Kasir
    public function kasirPage(Request $request)
    {
        // Set Timezone
        $now = Carbon::now('Asia/Jakarta');
        $hariIni = $now->format('Y-m-d');

        // 1. OTOMATIS PINDAHKAN STOK YANG SUDAH EXPIRED KE RETUR
        $stokKadaluarsa = Stok::whereDate('tanggal_kadaluarsa', '<=', $hariIni)
                              ->where('stok', '>', 0)
                              ->get();

        if ($stokKadaluarsa->count() > 0) {
            DB::transaction(function () use ($stokKadaluarsa) {
                foreach ($stokKadaluarsa as $item) {
                    Retur::create([
                        'produk_id'     => $item->produk_id,
                        'cabang'        => $item->cabang,
                        'jumlah'        => $item->stok,
                        'tanggal_retur' => Carbon::now('Asia/Jakarta'),
                        'alasan'        => 'Otomatis: Expired (Sudah kadaluarsa)',
                    ]);
                    $item->delete();
                }
            });

            session()->flash('warning', $stokKadaluarsa->count() . ' batch produk expired telah dipindahkan ke Retur.');
        }

        $user = Auth::user();
        $isCabangAdmin = $user && $user->role === 'cabang';

        $cabangs = collect();
        $cabangAktif = null;

        if ($isCabangAdmin) {
            $cabangs = Cabang::where('id', $user->cabang_id)->get();
            $cabangAktif = optional($cabangs->first())->nama_cabang;

            if (!$cabangAktif) {
                abort(403, 'Akun cabang Anda belum terhubung dengan data Cabang.');
            }
        } else {
            $cabangs = Cabang::orderBy('nama_cabang')->get();
            $cabangAktif = $request->query('cabang');

            if ($cabangAktif && !$cabangs->pluck('nama_cabang')->contains($cabangAktif)) {
                $cabangAktif = null;
            }

            if (!$cabangAktif) {
                $cabangAktif = optional($cabangs->first())->nama_cabang;
            }
        }

        // 2. AMBIL PRODUK DENGAN STOK (HANYA YANG BELUM EXPIRED)
        $produks = Produk::with(['stok' => function ($q) use ($hariIni) {
            $q->whereDate('tanggal_kadaluarsa', '>', $hariIni)->where('stok', '>', 0);
        }])->orderBy('nama')->get();

        // 3. HITUNG TOTAL STOK PER BRANCH
        $produkKasir = $produks->map(function ($p) use ($cabangAktif) {
            $kumpulanStok = $p->stok;

            if ($cabangAktif) {
                $kumpulanStok = $kumpulanStok->filter(function ($item) use ($cabangAktif) {
                    $cabangDiDatabase = strtolower(trim($item->cabang));
                    $cabangDiFilter   = strtolower(trim($cabangAktif));
                    return $cabangDiDatabase === $cabangDiFilter;
                });
            }

            $totalStok = $kumpulanStok->sum('stok');

            return [
                'id' => $p->id,
                'name'  => $p->nama,
                'nama'  => $p->nama,
                'price' => (float) ($p->harga ?? 0),
                'harga' => (float) ($p->harga ?? 0),
                'stock' => (int) $totalStok,
                'stok'  => (int) $totalStok,
                'image' => $p->foto ? asset($p->foto) : asset('images/fotoroti/IMG-20251111-WA0021.jpg'),
                'foto'  => $p->foto ? asset($p->foto) : asset('images/fotoroti/IMG-20251111-WA0021.jpg'),
            ];
        })->values();

        return view('admin.kasir', compact('cabangs', 'cabangAktif', 'produkKasir'));
    }

    // 2. Tampilkan Halaman Laporan
    public function index()
    {
        $laporans = Laporan::with('user')->latest()->get();
        // Pastikan view ini ada di resources/views/admin/laporan.blade.php
        return view('admin.laporan', compact('laporans'));
    }

    // 3. EXPORT PDF (FUNGSI BARU)
    public function exportPdf()
    {
        // Ambil data laporan
        $laporans = Laporan::with('user')->latest()->get();

        // Load view khusus PDF (bukan view index biasa)
        $pdf = Pdf::loadView('admin.laporan_pdf', compact('laporans'));

        // Atur ukuran kertas (A4, Potrait/Landscape)
        $pdf->setPaper('a4', 'portrait');

        // Download file
        return $pdf->download('laporan-transaksi.pdf');
    }

    // 4. PROSES SIMPAN
    public function simpanDariKasir(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $ringkasanBarang = [];

            foreach ($request->items as $item) {
                $produk = Produk::lockForUpdate()->find($item['id']);
                if (!$produk) continue;

                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->name} tidak cukup.");
                }

                $produk->stok -= $item['qty'];
                $produk->save();

                $ringkasanBarang[] = $produk->name . " (" . $item['qty'] . ")";
            }

            $listBarangString = implode(', ', $ringkasanBarang);
            if (strlen($listBarangString) > 150) {
                $listBarangString = substr($listBarangString, 0, 150) . '...';
            }

            $judulLaporan = "Penjualan: " . $listBarangString . ". Total Rp " . number_format($request->total, 0, ',', '.');

            Laporan::create([
                'judul'     => $judulLaporan,
                'user_id'   => Auth::id(),
                'tanggal'   => now(),
            ]);

            DB::commit();
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store transaksi dari Kasir (dipanggil via POST /admin/laporan)
     * Mengurangi stok di tabel `stoks` per batch (FIFO berdasarkan tanggal_masuk)
     * Menyimpan ringkasan item detail di kolom `deskripsi` (JSON)
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
            'cabang' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $details = [];

            foreach ($request->items as $item) {
                $prod = Produk::find($item['id']);
                if (!$prod) continue;

                $needed = intval($item['qty']);

                // Ambil batch stok yang tersedia untuk produk ini, prioritas by tanggal_masuk (FIFO)
                $batchesQuery = Stok::where('produk_id', $prod->id)
                    ->where('stok', '>', 0)
                    ->orderBy('tanggal_masuk');

                if ($request->filled('cabang')) {
                    $c = strtolower(trim($request->cabang));
                    $batchesQuery->whereRaw('lower(trim(cabang)) = ?', [$c]);
                }

                $batches = $batchesQuery->lockForUpdate()->get();

                foreach ($batches as $batch) {
                    if ($needed <= 0) break;
                    $take = min($batch->stok, $needed);

                    // kurangi stok batch
                    $batch->stok = $batch->stok - $take;
                    if ($batch->stok <= 0) {
                        $batch->delete();
                    } else {
                        $batch->save();
                    }

                    $details[] = [
                        'produk_id' => $prod->id,
                        'nama' => $prod->nama,
                        'qty' => $take,
                        'harga' => (float) ($prod->harga ?? 0),
                        'cabang' => $batch->cabang,
                        'batch_id' => $batch->id,
                    ];

                    $needed -= $take;
                }

                if ($needed > 0) {
                    throw new \Exception("Stok untuk produk {$prod->nama} tidak mencukupi (dibutuhkan {$item['qty']}).");
                }
            }

            // Simpan Laporan: gabungkan ke laporan hari ini jika sudah ada (satu hari = satu laporan)
            $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $existing = Laporan::whereDate('tanggal', $today)->first();

            if ($existing) {
                // Merge dengan laporan yang sudah ada
                $old = [];
                if ($existing->deskripsi) {
                    $decoded = json_decode($existing->deskripsi, true);
                    if (is_array($decoded)) $old = $decoded;
                }

                $combined = array_merge($old, $details);

                // Agregasi per produk+cabang+batch_id agar tidak ada duplikat
                $agg = [];
                foreach ($combined as $it) {
                    $key = ($it['produk_id'] ?? '') . '|' . ($it['cabang'] ?? '') . '|' . ($it['batch_id'] ?? '');
                    if (!isset($agg[$key])) {
                        $agg[$key] = $it;
                        $agg[$key]['qty'] = intval($it['qty'] ?? 0);
                    } else {
                        $agg[$key]['qty'] = intval($agg[$key]['qty']) + intval($it['qty'] ?? 0);
                    }
                }
                $merged = array_values($agg);

                // Rebuild judul dari aggregated items
                $byName = [];
                foreach ($merged as $m) {
                    $name = $m['nama'] ?? '';
                    $byName[$name] = ($byName[$name] ?? 0) + intval($m['qty'] ?? 0);
                }
                $judulParts = [];
                foreach ($byName as $n => $q) {
                    $judulParts[] = $n . ' (' . $q . ')';
                }
                $judul = 'Penjualan: ' . implode(', ', $judulParts);
                if (strlen($judul) > 150) $judul = substr($judul, 0, 150) . '...';

                $existing->deskripsi = json_encode($merged, JSON_UNESCAPED_UNICODE);
                $existing->judul = $judul;
                $existing->save();
            } else {
                // Buat laporan baru untuk hari ini
                $judul = 'Penjualan: ' . collect($details)->map(fn($d) => $d['nama'] . ' (' . $d['qty'] . ')')->unique()->values()->join(', ');
                if (strlen($judul) > 150) {
                    $judul = substr($judul, 0, 150) . '...';
                }

                Laporan::create([
                    'judul' => $judul,
                    'deskripsi' => json_encode($details, JSON_UNESCAPED_UNICODE),
                    'tanggal' => $today,
                ]);
            }

            DB::commit();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Export daily report as CSV. Query param `date=YYYY-MM-DD` optional (defaults to today)
     */
    public function exportDaily(Request $request)
    {
        $date = $request->query('date', Carbon::now('Asia/Jakarta')->format('Y-m-d'));

        $laporans = Laporan::whereDate('tanggal', $date)->get();

        $rows = [];
        // header row for CSV
        $header = ['laporan_id','tanggal','judul','produk_id','nama','qty','harga','cabang','batch_id'];

        foreach ($laporans as $lap) {
            $details = [];
            if ($lap->deskripsi) {
                $decoded = json_decode($lap->deskripsi, true);
                if (is_array($decoded)) $details = $decoded;
            }

            if (count($details) === 0) {
                $rows[] = [$lap->id, $lap->tanggal, $lap->judul, '', '', '', '', '', ''];
            } else {
                foreach ($details as $d) {
                    $rows[] = [
                        $lap->id,
                        $lap->tanggal,
                        $lap->judul,
                        $d['produk_id'] ?? '',
                        $d['nama'] ?? '',
                        $d['qty'] ?? '',
                        $d['harga'] ?? '',
                        $d['cabang'] ?? '',
                        $d['batch_id'] ?? '',
                    ];
                }
            }
        }

        $filename = "laporan-harian-{$date}.csv";
        $handle = fopen('php://memory', 'r+');
        fputcsv($handle, $header);
        foreach ($rows as $r) {
            fputcsv($handle, $r);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    /**
     * Download single laporan as CSV
     */
    public function download($id)
    {
        $lap = Laporan::findOrFail($id);

        $header = ['laporan_id','tanggal','judul','produk_id','nama','qty','harga','cabang','batch_id'];
        $rows = [];

        $details = [];
        if ($lap->deskripsi) {
            $decoded = json_decode($lap->deskripsi, true);
            if (is_array($decoded)) $details = $decoded;
        }

        if (count($details) === 0) {
            $rows[] = [$lap->id, $lap->tanggal, $lap->judul, '', '', '', '', '', ''];
        } else {
            foreach ($details as $d) {
                $rows[] = [
                    $lap->id,
                    $lap->tanggal,
                    $lap->judul,
                    $d['produk_id'] ?? '',
                    $d['nama'] ?? '',
                    $d['qty'] ?? '',
                    $d['harga'] ?? '',
                    $d['cabang'] ?? '',
                    $d['batch_id'] ?? '',
                ];
            }
        }

        $filename = "laporan-{$lap->id}-{$lap->tanggal}.csv";
        $handle = fopen('php://memory', 'r+');
        fputcsv($handle, $header);
        foreach ($rows as $r) {
            fputcsv($handle, $r);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function destroy($id)
    {
        Laporan::findOrFail($id)->delete();
        return back()->with('success', 'Laporan dihapus');
    }
}

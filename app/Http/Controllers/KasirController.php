<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Cabang;
use App\Models\Stok;
use App\Models\Retur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index(Request $request)
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

        // 2. SIAPKAN DAFTAR CABANG
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

        // 3. AMBIL DATA PRODUK DENGAN STOK (HANYA YANG BELUM EXPIRED)
        $produks = Produk::with(['stok' => function ($q) use ($hariIni) {
            $q->whereDate('tanggal_kadaluarsa', '>', $hariIni)->where('stok', '>', 0);
        }])->orderBy('nama')->get();

        // 4. HITUNG TOTAL STOK PER BRANCH (EXPIRED SUDAH DIFILTER DI QUERY)
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
                'price' => (float)($p->harga ?? 0),
                'harga' => (float)($p->harga ?? 0),
                'stock' => (int)$totalStok,
                'stok'  => (int)$totalStok,
                'image' => $p->foto ? asset($p->foto) : asset('images/no-image.jpg'),
            ];
        })->values();

        // 5. STOK TABLE (HANYA NON-EXPIRED)
        $queryStok = Stok::with('produk')
            ->whereDate('tanggal_kadaluarsa', '>', $hariIni)
            ->where('stok', '>', 0);

        if ($cabangAktif) {
            $queryStok->where('cabang', $cabangAktif);
        }

        $stoks = $queryStok->orderBy('tanggal_kadaluarsa', 'asc')->get();

        return view('admin.kasir', compact(
            'cabangs',
            'cabangAktif',
            'produkKasir',
            'stoks',
            'isCabangAdmin'
        ));
    }
}

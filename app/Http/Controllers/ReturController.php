<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use App\Models\Produk;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;
class ReturController extends Controller
{
    public function index(Request $request)
    {
        // --- MULAI LOGIKA OTOMATIS KADALUARSA ---

        // 1. Cari stok yang tanggal kadaluarsanya sudah lewat HARI INI dan jumlahnya > 0
        $stokKadaluarsa = Stok::whereDate('tanggal_kadaluarsa', '<', Carbon::now())
                              ->where('stok', '>', 0)
                              ->get();

        if ($stokKadaluarsa->count() > 0) {
            // Gunakan transaction agar data aman (kalau gagal insert, tidak terhapus)
            DB::transaction(function () use ($stokKadaluarsa) {
                foreach ($stokKadaluarsa as $item) {
                    // A. Buat data baru di tabel Retur
                    Retur::create([
                        'produk_id'     => $item->produk_id,
                        'cabang'        => $item->cabang,
                        'jumlah'        => $item->stok, // Ambil semua sisa stok
                        'tanggal_retur' => Carbon::now(), // Tanggal hari ini
                        'alasan'        => 'Otomatis: Kadaluarsa pada ' . Carbon::parse($item->tanggal_kadaluarsa)->format('d/m/Y'),
                    ]);

                    // B. Hapus data dari tabel Stok (sesuai permintaan Anda)
                    $item->delete();
                }
            });

            // Opsional: Beri pesan flash session bahwa ada data yang dipindahkan
            session()->flash('warning', $stokKadaluarsa->count() . ' item stok kadaluarsa telah otomatis dipindahkan ke Retur.');
        }
        // 1. Ambil data Cabang untuk Filter
        $cabangs = Cabang::all();
        $cabangDipilih = $request->query('cabang');

        // 2. Query Data Retur (Eager Load 'produk' agar bisa ambil nama barang)
        $query = Retur::with('produk')->latest();

        // Filter Cabang jika ada
        if ($cabangDipilih) {
            $query->where('cabang', $cabangDipilih);
        }

        $returs = $query->get();

        // 3. Ambil Produk untuk Modal "Tambah Manual" (Opsional)
        $produks = Produk::all();

        return view('admin.retur', compact('returs', 'cabangs', 'produks', 'cabangDipilih'));
    }

    // Fitur Tambah Retur Manual (Misal barang rusak, bukan kadaluarsa)
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'cabang'    => 'required',
            'jumlah'    => 'required|numeric|min:1',
            'alasan'    => 'required',
            'tanggal'   => 'required|date',
        ]);

        $produkId = $request->produk_id;
        $cabang = $request->cabang;
        $needed = intval($request->jumlah);

        try {
            DB::beginTransaction();

            // Ambil batch stok sesuai produk dan cabang, urut FIFO berdasarkan tanggal_masuk
            $batchesQuery = Stok::where('produk_id', $produkId)
                ->where('stok', '>', 0)
                ->orderBy('tanggal_masuk');

            // cocokkan cabang secara case-insensitive
            $batchesQuery->whereRaw('lower(trim(cabang)) = ?', [strtolower(trim($cabang))]);

            $batches = $batchesQuery->lockForUpdate()->get();

            foreach ($batches as $batch) {
                if ($needed <= 0) break;
                $take = min($batch->stok, $needed);

                $batch->stok = $batch->stok - $take;
                if ($batch->stok <= 0) {
                    $batch->delete();
                } else {
                    $batch->save();
                }

                $needed -= $take;
            }

            if ($needed > 0) {
                // Tidak cukup stok di cabang tersebut -> rollback dan beritahu user
                DB::rollBack();
                return redirect()->back()->with('error', 'Stok tidak mencukupi di cabang "' . e($cabang) . '" untuk produk yang dipilih.');
            }

            // Simpan data retur setelah stok berhasil dikurangi
            Retur::create([
                'produk_id'     => $produkId,
                'cabang'        => $cabang,
                'jumlah'        => intval($request->jumlah),
                'alasan'        => $request->alasan,
                'tanggal_retur' => $request->tanggal,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data retur berhasil ditambahkan dan stok telah dikurangi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses retur: ' . $e->getMessage());
        }
    }

    // Hapus Data Retur
    public function destroy($id)
    {
        $retur = Retur::findOrFail($id);
        $retur->delete();

        return redirect()->back()->with('success', 'Data retur berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use App\Models\Cabang;
use App\Models\Retur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(Request $request)
    {
        // Set Timezone agar akurat (Ganti sesuai lokasi, misal Asia/Makassar jika WITA)
        $now = Carbon::now('Asia/Jakarta');
        $hariIni = $now->format('Y-m-d');
        $tujuhHariKedepan = $now->copy()->addDays(7)->format('Y-m-d');

        // 1. OTOMATIS PINDAHKAN STOK YANG SUDAH BASI (EXPIRED KEMARIN/LAMPAU) KE RETUR
        // Logika: Jika tanggal kadaluarsa <= hari ini, maka sudah tidak layak jual.
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
                        'alasan'        => 'Otomatis: Expired (Melewati batas jual)',
                    ]);
                    $item->delete(); // Hapus dari stok aktif
                }
            });

            session()->flash('warning', $stokKadaluarsa->count() . ' batch roti expired (kemarin/sebelumnya) telah otomatis dipindahkan ke menu Retur.');
        }

        // 2. FITUR BARU: PERINGATAN STOK YANG AKAN EXPIRED (3-7 HARI KE DEPAN)
        // Ini menjawab kebutuhan Anda: Roti yang umur simpannya tinggal sedikit tetap muncul tapi diberi info.
        $stokHampirExpired = Stok::where('stok', '>', 0)
            ->whereDate('tanggal_kadaluarsa', '>=', $hariIni)
            ->whereDate('tanggal_kadaluarsa', '<=', $tujuhHariKedepan)
            ->count();

        if ($stokHampirExpired > 0) {
            session()->now('info', "Perhatian: Ada $stokHampirExpired batch roti yang akan expired dalam 1-7 hari ke depan. Segera jual atau diskon!");
        }

        // 3. DATA UNTUK VIEW
        $cabangs = Cabang::all();
        $daftarNamaCabang = $cabangs->pluck('nama_cabang')->toArray();
        $cabangDipilih = $request->query('cabang');

        $query = Stok::with('produk');
        if ($cabangDipilih && in_array($cabangDipilih, $daftarNamaCabang)) {
            $query->where('cabang', $cabangDipilih);
        }

        // FILTER: Hanya tampilkan stok yang belum expired (tanggal_kadaluarsa > hari ini)
        $query->whereDate('tanggal_kadaluarsa', '>', $hariIni);

        // Urutkan berdasarkan tanggal kadaluarsa terdekat agar yang mau expired muncul paling atas
        $stoks = $query->orderBy('tanggal_kadaluarsa', 'asc')->get();

        $rotis = Produk::orderBy('nama')->get();

        return view('admin.stok', compact('stoks', 'rotis', 'cabangDipilih', 'cabangs'));
    }

    public function store(Request $request)
    {
        $daftarNamaCabang = Cabang::pluck('nama_cabang')->toArray();

        $validated = $request->validate([
            'cabang' => ['required', 'string', Rule::in($daftarNamaCabang)],
            'tanggal_masuk' => 'required|date',
            'stok' => 'array',
        ]);

        $cabangDipilih = $validated['cabang'];
        $tanggalMasuk = $validated['tanggal_masuk'];
        $jumlahDitambahkan = 0;

        if ($request->has('stok')) {
            foreach ($request->stok as $item) {
                if (isset($item['jumlah']) && $item['jumlah'] > 0) {

                    // VALIDASI LOGIS (Opsional):
                    // Jika user input tanggal kadaluarsa hari ini atau kemarin, ingatkan/tetap simpan tapi akan langsung retur besoknya.
                    // Di sini kita simpan saja apa adanya sesuai input user.

                    Stok::create([
                        'produk_id' => $item['produk_id'],
                        'cabang' => $cabangDipilih,
                        'tanggal_masuk' => $tanggalMasuk,
                        'tanggal_kadaluarsa' => $item['tanggal_kadaluarsa'] ?? null,
                        'stok' => $item['jumlah'],
                    ]);
                    $jumlahDitambahkan++;
                }
            }
        }

        if ($jumlahDitambahkan > 0) {
            return redirect()->route('stok.index', ['cabang' => $cabangDipilih])
                ->with('success', "Stok berhasil ditambahkan ke {$cabangDipilih}!");
        }

        return redirect()->route('stok.index', ['cabang' => $cabangDipilih])
            ->with('warning', 'Tidak ada stok yang disimpan (jumlah 0).');
    }
}

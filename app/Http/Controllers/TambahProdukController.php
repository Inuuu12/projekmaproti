<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class TambahProdukController extends Controller
{
    // ✅ Tampilkan halaman tambah produk
    public function create()
    {
        $produks = Produk::all();
        return view('admin.tambahproduk', compact('produks'));
    }

    // ✅ Tampilkan daftar produk
    public function index()
    {
        $produks = Produk::all();
        return view('admin.tambahproduk', compact('produks'));
    }

    // ✅ Simpan produk baru TANPA menambahkan stok otomatis ke semua cabang
    public function store(Request $request)
    {
        // 1. UBAH VALIDASI
        // Hapus 'tanggal_kadaluarsa', ganti jadi 'deskripsi'
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string', // <-- INI YANG BARU
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload foto (Bagian ini TIDAK BERUBAH)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaProduk = str_replace(' ', '_', $validated['nama']);
            $namaProduk = preg_replace('/[^A-Za-z0-9_]/', '', $namaProduk);
            $namaFile = time() . '_' . $namaProduk . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

            $foto->move(public_path('images/fotoroti'), $namaFile);
            $fotoPath = 'images/fotoroti/' . $namaFile;
        }

        // 2. UBAH SAAT CREATE KE DATABASE
        // Ganti 'tanggal_kadaluarsa' jadi 'deskripsi'
        Produk::create([
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'], // <-- INI YANG BARU
            'foto' => $fotoPath,
        ]);

        return redirect()->route('tambahproduk.index')
            ->with('success', 'Produk berhasil ditambahkan! Tambahkan stok melalui halaman Stok.');
    }


    // ✅ Hapus produk
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);

            // Hapus foto dari storage jika ada
            if ($produk->foto && file_exists(public_path($produk->foto))) {
                unlink(public_path($produk->foto));
            }

            $produk->delete();

            return redirect()->route('tambahproduk.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('tambahproduk.index')
                ->with('error', 'Gagal menghapus produk');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class TambahProdukController extends Controller
{
    // Tampilkan halaman dashboard
     public function create()
    {
        $produks = Produk::all();
        return view('admin.tambahproduk', compact('produks')); // pastikan file view ini ada
    }

    public function index()
    {
        $produks = Produk::all();
        return view('admin.tambahproduk', compact('produks'));
    }


    // Simpan produk baru dari form kasir
    public function store(Request $request)
    {
        // Validasi input
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'tanggal_kadaluarsa' => 'required|date',
    ]);
        // Simpan ke database
    Produk::create([
        'nama' => $validated['nama'],
        'harga' => $validated['harga'],
        'tanggal_kadaluarsa' => $validated['tanggal_kadaluarsa'],
    ]);

        // Pastikan data diterima
        if (!$request->has('produk') || !is_array($request->produk)) {
        return back()->with('error', 'Tidak ada data produk yang dikirim.');
    }

        // Redirect ke dashboard setelah simpan
        return redirect()->route('admin.tambahproduk')->with('success', 'Data produk berhasil disimpan!');
    }
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $produk->delete();

            return redirect()->route('tambahproduk.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('tambahproduk.index')
                ->with('error', 'Gagal menghapus produk');
        }
    }
}

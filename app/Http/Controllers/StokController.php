<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;

class StokController extends Controller
{
    public function index()
    {
        $rotis = Stok::all();
        return view('admin.stok', compact('rotis'));
    }
    

    public function store(Request $request)
    {
        $data = $request->input('jumlah'); // array jumlah dari form
        $rotis = $request->input('rotis'); // array nama roti dari form

        foreach ($rotis as $index => $nama_roti) {
            $jumlah = $data[$index] ?? 0;
            $harga = $request->input('harga')[$index] ?? 0;

              Stok::updateOrCreate(
                ['nama_roti' => $nama_roti],
                ['harga' => $harga, 'jumlah' => $jumlah]
            );
        }
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua produk dari database
        $produks = Produk::all();

        // Kirim ke view dashboard
             return view('admin.dashboard', compact('produks'))->with('success', 'Produk berhasil ditambahkan!');

        // ⬆️ Pastikan nama view-nya sesuai dengan file Blade kamu
    }
}

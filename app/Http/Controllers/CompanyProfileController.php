<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class CompanyProfileController extends Controller
{
    public function show()
    {
        return view('company-profile');
    }

    public function products()
    {
        $produks = Produk::all();
        return view('products', compact('produks'));
    }
}


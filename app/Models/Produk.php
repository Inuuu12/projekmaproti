<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // Pastikan nama tabel benar
    protected $guarded = [];

    // --- INI ADALAH JEMBATANNYA ---
    // Tanpa fungsi ini, KasirController tidak bisa membaca stok
    public function stok()
    {
        // Artinya: Satu Produk punya Banyak data Stok
        return $this->hasMany(Stok::class, 'produk_id', 'id');
    }
}

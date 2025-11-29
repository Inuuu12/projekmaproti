<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stoks';

    protected $fillable = [
        'produk_id',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'stok',
        'cabang'
    ];
    public function produk() // <-- Nama method ini harus 'produk'
    {
        // Asumsi foreign key di tabel 'stoks' adalah 'produk_id'
        // dan Model targetnya adalah App\Models\Produk
        return $this->belongsTo(Produk::class);
    }
}


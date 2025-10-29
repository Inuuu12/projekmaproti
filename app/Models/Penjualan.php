<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = [
        'produk_id',
        'jumlah_terjual',
        'total_harga',
        'tanggal_jual',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

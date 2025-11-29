<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Retur extends Model
{
    use HasFactory;

    protected $table = 'returs';

    protected $fillable = [
        'produk_id',
        'cabang',
        'jumlah',
        'alasan',
        'tanggal_retur'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

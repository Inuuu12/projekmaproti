<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stoks';

    protected $fillable = [
        'nama',
        'harga',
        'tanggal_masuk',
        'tanggal_kadaluarsa',
        'stok',
        'cabang_id'
    ];
}


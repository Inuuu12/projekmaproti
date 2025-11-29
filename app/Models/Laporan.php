<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    //
    protected $table = 'laporan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'user_id',
    ];

    /**
     * Relasi ke user yang membuat laporan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public $timestamps = true;
}

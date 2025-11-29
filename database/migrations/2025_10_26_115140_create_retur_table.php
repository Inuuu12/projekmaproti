<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan nama tabelnya 'returs' (jamak/plural)
        Schema::create('returs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('cabang');
            $table->integer('jumlah');
            $table->text('alasan');
            $table->date('tanggal_retur');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // PERBAIKAN: Ubah 'retur' menjadi 'returs'
        Schema::dropIfExists('returs');
    }
};


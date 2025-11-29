<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->date('tanggal_masuk'); // tanggal masuk stok
            $table->date('tanggal_kadaluarsa')->nullable(); // tanggal kadaluarsa, bisa null
            $table->integer('stok')->default(0); // jumlah stok
            $table->string('cabang'); // cabang A, B, atau C
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};

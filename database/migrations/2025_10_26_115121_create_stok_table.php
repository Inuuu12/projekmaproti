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
            $table->string('nama'); // nama produk
            $table->decimal('harga', 15, 2); // harga produk
            $table->date('tanggal_masuk'); // tanggal masuk stok
            $table->date('tanggal_kadaluarsa')->nullable(); // tanggal kadaluarsa, bisa null
            $table->integer('stok')->default(0); // jumlah stok
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};

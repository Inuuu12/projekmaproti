<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up(): void
//     {
//         Schema::create('laporan', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('cabang_id')->constrained('cabang')->onDelete('cascade');
//             $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
//             $table->integer('jumlah_terjual');
//             $table->decimal('total_pendapatan', 10, 2);
//             $table->date('tanggal');
//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('laporan');
//     }
// };
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};

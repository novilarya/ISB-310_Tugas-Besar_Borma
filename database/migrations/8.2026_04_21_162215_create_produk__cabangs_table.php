<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_cabangs', function (Blueprint $table) {
            $table->id('id_produk_cabang');
            $table->foreignId('id_produk')->constrained('produks', 'id_produk');
            $table->foreignId('id_cabang')->constrained('cabangs', 'id_cabang');
            $table->integer('jumlah_stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk__cabangs');
    }
};

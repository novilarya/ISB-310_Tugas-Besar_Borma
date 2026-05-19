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
        Schema::create('promos', function (Blueprint $table) {
            $table->id('id_promo');
            $table->foreignId('id_cabang')->constrained('cabangs', 'id_cabang');
            $table->foreignId('id_produk_pemicu')->constrained('produks', 'id_produk');
            $table->foreignId('id_produk_hadiah')->nullable()->constrained('produks', 'id_produk');
            $table->string('nama_voucher');
            $table->string('kode_voucher')->nullable();
            $table->integer('kuantitas_pemicu')->default(1);
            $table->integer('kuantitas_hadiah')->default(0);
            $table->decimal('potongan_harga', 15, 2)->default(0);
            $table->decimal('min_transaksi', 15, 2)->default(0);
            $table->decimal('max_promo', 15, 2)->default(0);
            $table->integer('kuota_promo')->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};

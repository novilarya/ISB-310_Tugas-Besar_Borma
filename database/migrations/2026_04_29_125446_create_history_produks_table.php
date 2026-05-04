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
        Schema::create('history_produk', function (Blueprint $table) {
            $table->id('id_history');
            $table->unsignedBigInteger('id_produk');
            $table->decimal('harga_reguler_lama', 10, 2)->nullable();
            $table->decimal('harga_reguler_baru', 10, 2);
            $table->decimal('harga_member_lama', 10, 2)->nullable();
            $table->decimal('harga_member_baru', 10, 2);
            $table->string('admin');
            $table->timestamps();
            
            // Note: Uncomment this if id_produk exists on produk table
            // $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_produks');
    }
};

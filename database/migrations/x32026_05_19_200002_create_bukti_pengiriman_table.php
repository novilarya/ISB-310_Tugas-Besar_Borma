<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Stores proof of delivery: photo, receiver name, and driver notes.
     */
    public function up(): void
    {
        if (!Schema::hasTable('bukti_pengiriman')) {
            Schema::create('bukti_pengiriman', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_pesanan')->constrained('pesanans', 'id_pesanan')->onDelete('cascade');
                $table->string('foto_bukti');
                $table->string('nama_penerima');
                $table->text('catatan_driver')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pengiriman');
    }
};

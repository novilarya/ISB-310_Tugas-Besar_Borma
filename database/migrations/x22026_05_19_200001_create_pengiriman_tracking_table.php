<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tracks each status change for a delivery with timestamp.
     */
    public function up(): void
    {
        if (!Schema::hasTable('pengiriman_tracking')) {
            Schema::create('pengiriman_tracking', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_pesanan')->constrained('pesanans', 'id_pesanan')->onDelete('cascade');
                $table->enum('status', ['pending','diterima_driver','ditolak_driver','diambil','dalam_pengiriman','diterima','gagal']);
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman_tracking');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Logs driver rejections with mandatory reason.
     */
    public function up(): void
    {
        if (!Schema::hasTable('penolakan_pengiriman')) {
            Schema::create('penolakan_pengiriman', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_pesanan')->constrained('pesanans', 'id_pesanan')->onDelete('cascade');
                $table->foreignId('id_kurir')->constrained('kurirs', 'id_kurir')->onDelete('cascade');
                $table->text('alasan');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penolakan_pengiriman');
    }
};

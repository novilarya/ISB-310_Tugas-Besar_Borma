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
        Schema::create('kurirs', function (Blueprint $table) {
            $table->id('id_kurir');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('kendaraan');
            $table->string('warna_kendaraan');
            $table->string('plat_nomor');
            $table->foreignId('id_cabang')->constrained('cabangs', 'id_cabang')->onDelete('cascade');
            $table->decimal('pendapatan_pengiriman', 15, 2);
            $table->enum('status_mengirim', ['Sedang Mengirim', 'Tidak Mengirim']);
            $table->enum('status_aktif', ['Aktif', 'Tidak Aktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurirs');
    }
};

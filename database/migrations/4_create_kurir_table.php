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
        Schema::create('kurir', function (Blueprint $table) {
            $table->id('id_kurir');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->string('kendaraan');
            $table->string('warna_kendaraan');
            $table->string('plat_nomor');
            $table->foreignId('id_cabang')->constrained('cabang', 'id_cabang')->onDelete('cascade');
            $table->decimal('pendapatan_pengiriman', 15, 2)->default(0);
            $table->enum('status_mengirim', ['Sedang Mengirim', 'Tidak Mengirim'])->default('Tidak Mengirim');
            $table->enum('status_aktif', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->decimal('driver_lat', 10, 7)->nullable()->after('status_aktif');
            $table->decimal('driver_lng', 10, 7)->nullable()->after('driver_lat');
            $table->timestamp('location_updated_at')->nullable()->after('driver_lng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};

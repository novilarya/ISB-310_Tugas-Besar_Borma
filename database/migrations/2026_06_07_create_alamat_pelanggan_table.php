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
        Schema::create('alamat_pelanggan', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
            $table->string('label')->default('Alamat Tambahan'); // e.g. "Kantor", "Rumah Kedua"
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->text('alamat');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_pelanggan');
    }
};

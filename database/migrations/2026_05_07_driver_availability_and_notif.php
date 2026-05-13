<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom availability ke kurirs
        Schema::table('kurirs', function (Blueprint $table) {
            $table->boolean('is_available')->default(true)->after('plat_nomor');
            $table->decimal('lat', 10, 7)->nullable()->after('is_available');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
        });

        // Tabel notifikasi untuk dispatch driver
        Schema::create('notifikasi_drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kurir');
            $table->unsignedBigInteger('id_pesanan');
            $table->string('status')->default('pending'); // pending | accepted | rejected
            $table->string('pesan')->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamps();

            $table->foreign('id_kurir')->references('id_kurir')->on('kurirs')->onDelete('cascade');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_drivers');
        Schema::table('kurirs', function (Blueprint $table) {
            $table->dropColumn(['is_available', 'lat', 'lng']);
        });
    }
};

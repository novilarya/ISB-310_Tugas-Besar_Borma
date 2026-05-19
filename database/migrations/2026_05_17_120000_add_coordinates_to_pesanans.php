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
        Schema::table('pesanans', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('alamat_pengiriman');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->text('alasan_gagal')->nullable()->after('bukti_pengiriman');
            $table->decimal('potongan_driver', 15, 2)->default(0)->after('alasan_gagal');
            $table->integer('review_rating')->nullable()->after('potongan_driver');
            $table->text('review_text')->nullable()->after('review_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'alasan_gagal', 'potongan_driver', 'review_rating', 'review_text']);
        });
    }
};

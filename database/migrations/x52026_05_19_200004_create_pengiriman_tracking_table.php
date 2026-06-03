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
        if (!Schema::hasTable('pengiriman_tracking')) {
            Schema::create('pengiriman_tracking', function (Blueprint $table) {
                $table->id('id_tracking');
                $table->foreignId('id_pesanan')->constrained('pesanans', 'id_pesanan')->onDelete('cascade');
                $table->enum('status', [
                    'pending',
                    'diterima_driver',
                    'diambil',
                    'dalam_pengiriman',
                    'diterima',
                    'gagal',
                    'ditolak_driver'
                ])->default('pending');
                $table->timestamp('waktu_update')->nullable();
                $table->text('keterangan')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->timestamps();
            });
        } else {
            // Table exists, add missing columns if needed
            Schema::table('pengiriman_tracking', function (Blueprint $table) {
                if (!Schema::hasColumn('pengiriman_tracking', 'waktu_update')) {
                    $table->timestamp('waktu_update')->nullable()->after('keterangan');
                }
                if (!Schema::hasColumn('pengiriman_tracking', 'latitude')) {
                    $table->decimal('latitude', 10, 8)->nullable()->after('waktu_update');
                }
                if (!Schema::hasColumn('pengiriman_tracking', 'longitude')) {
                    $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
                }
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

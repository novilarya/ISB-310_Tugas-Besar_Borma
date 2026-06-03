<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Extends pesanans table with new driver status values and columns.
     */
    public function up(): void
    {
        // Change to string temporarily to prevent data truncation
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN status_pesanan VARCHAR(255)");

        // Update data to match new enum
        DB::statement("UPDATE pesanans SET status_pesanan = 'pending' WHERE status_pesanan = 'menunggu'");
        DB::statement("UPDATE pesanans SET status_pesanan = 'gagal' WHERE status_pesanan = 'gagal_kirim'");

        // Update enum status_pesanan to include new statuses
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN status_pesanan ENUM('pending','diterima_driver','ditolak_driver','diambil','dalam_pengiriman','diterima','gagal') DEFAULT 'pending'");

        // Add new columns for delivery details
        Schema::table('pesanans', function (Blueprint $table) {
            // Ignore errors if columns already exist (in case of partial rollback)
            if (!Schema::hasColumn('pesanans', 'nama_penerima')) {
                $table->string('nama_penerima')->nullable()->after('bukti_pengiriman');
            }
            if (!Schema::hasColumn('pesanans', 'catatan_driver')) {
                $table->text('catatan_driver')->nullable()->after('nama_penerima');
            }
            if (!Schema::hasColumn('pesanans', 'catatan_pengiriman')) {
                $table->text('catatan_pengiriman')->nullable()->after('catatan_driver');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert to string first
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN status_pesanan VARCHAR(255)");

        // Revert data
        DB::statement("UPDATE pesanans SET status_pesanan = 'diambil' WHERE status_pesanan = 'diterima_driver'");
        DB::statement("UPDATE pesanans SET status_pesanan = 'menunggu' WHERE status_pesanan IN ('ditolak_driver', 'pending')");
        DB::statement("UPDATE pesanans SET status_pesanan = 'gagal_kirim' WHERE status_pesanan = 'gagal'");

        // Then modify enum back to old values
        DB::statement("ALTER TABLE pesanans MODIFY COLUMN status_pesanan ENUM('menunggu','diambil','dalam_pengiriman','diterima','gagal_kirim') DEFAULT 'menunggu'");

        Schema::table('pesanans', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('pesanans', 'nama_penerima')) $columns[] = 'nama_penerima';
            if (Schema::hasColumn('pesanans', 'catatan_driver')) $columns[] = 'catatan_driver';
            if (Schema::hasColumn('pesanans', 'catatan_pengiriman')) $columns[] = 'catatan_pengiriman';
            
            if (count($columns) > 0) {
                $table->dropColumn($columns);
            }
        });
    }
};

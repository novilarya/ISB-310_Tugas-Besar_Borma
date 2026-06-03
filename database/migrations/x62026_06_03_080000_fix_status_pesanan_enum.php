<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Sesuaikan ENUM status_pesanan dengan nilai yang digunakan controller.
     * Nilai lama (lowercase/Title Case berbeda) diganti ke format baru yang konsisten.
     */
    public function up(): void
    {
        // Step 1: Ubah kolom ke VARCHAR sementara agar bisa migrasi data lama
        DB::statement("ALTER TABLE `pesanans` MODIFY `status_pesanan` VARCHAR(50) NOT NULL DEFAULT 'Menunggu Konfirmasi'");

        // Step 2: Normalisasi nilai lama ke format baru
        $map = [
            'menunggu'          => 'Menunggu Konfirmasi',
            'Menunggu'          => 'Menunggu Konfirmasi',
            'diambil'           => 'Disiapkan',
            'dalam_pengiriman'  => 'Sedang Dikirim',
            'diterima'          => 'Diterima',
            'gagal_kirim'       => 'Gagal Kirim',
        ];

        foreach ($map as $old => $new) {
            DB::statement("UPDATE `pesanans` SET `status_pesanan` = ? WHERE `status_pesanan` = ?", [$new, $old]);
        }

        // Step 3: Ubah ke ENUM final dengan nilai lengkap
        DB::statement("ALTER TABLE `pesanans` MODIFY `status_pesanan` ENUM(
            'Menunggu Konfirmasi',
            'Disiapkan',
            'Mencari Kurir',
            'Sedang Dikirim',
            'Diterima',
            'Gagal Kirim'
        ) NOT NULL DEFAULT 'Menunggu Konfirmasi'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `pesanans` MODIFY `status_pesanan` ENUM(
            'Menunggu',
            'Disiapkan',
            'Mencari Kurir',
            'Sedang Dikirim',
            'Diterima'
        ) NOT NULL DEFAULT 'Menunggu'");
    }
};

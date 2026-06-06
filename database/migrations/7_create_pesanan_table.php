<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration utama untuk tabel pesanans dan semua tabel turunannya:
 *   - pesanans
 *   - pengiriman_tracking
 *   - penolakan_pengiriman
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Tabel Pesanan ────────────────────────────────────────────────
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan');
            $table->foreignId('id_cabang')->constrained('cabang', 'id_cabang');
            $table->foreignId('id_kurir')->nullable()->constrained('kurir', 'id_kurir');
            $table->foreignId('id_promo')->nullable()->constrained('promo', 'id_promo');
            $table->dateTime('tanggal_pemesanan');
            $table->decimal('total_belanja', 15, 2);
            $table->decimal('biaya_pengiriman', 15, 2);
            $table->decimal('diskon_voucher', 15, 2)->default(0);
            $table->decimal('total_tagihan', 15, 2);
            $table->string('metode_pembayaran');
            $table->text('alamat_pengiriman');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status_pesanan', [
                'Menunggu',
                'Disiapkan',
                'mencari_driver',
                'diterima_driver',
                'diambil',
                'dalam_pengiriman',
                'diterima',
                'selesai',
                'gagal',
                'ditolak_driver'
            ])->default('Menunggu');
            $table->dateTime('estimasi_tiba')->nullable();
            $table->string('bukti_pengiriman')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->text('catatan_driver')->nullable();
            $table->text('catatan_pengiriman')->nullable();
            $table->integer('review_rating')->nullable();
            $table->text('review_text')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->string('snap_token')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });

        // ── 2. Tabel Tracking Pengiriman ────────────────────────────────────
        Schema::create('pengiriman_tracking', function (Blueprint $table) {
            $table->id('id_tracking');
            $table->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan')->onDelete('cascade');
            $table->enum('status', [
                'Menunggu',
                'Disiapkan',
                'mencari_driver',
                'diterima_driver',
                'diambil',
                'dalam_pengiriman',
                'diterima',
                'selesai',
                'gagal',
                'ditolak_driver'
            ])->default('Menunggu');
            $table->timestamp('waktu_update')->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });


        // ── 4. Tabel Penolakan Pengiriman ───────────────────────────────────
        Schema::create('penolakan_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan')->onDelete('cascade');
            $table->foreignId('id_kurir')->constrained('kurir', 'id_kurir')->onDelete('cascade');
            $table->text('alasan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penolakan_pengiriman');
        Schema::dropIfExists('pengiriman_tracking');
        Schema::dropIfExists('pesanan');
    }
};

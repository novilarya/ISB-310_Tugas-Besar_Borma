<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pelanggan')->constrained('pelanggans', 'id_pelanggan');
            $table->foreignId('id_cabang')->constrained('cabangs', 'id_cabang');
            $table->foreignId('id_kurir')->nullable()->constrained('kurirs', 'id_kurir');
            $table->foreignId('id_promo')->nullable()->constrained('promos', 'id_promo');
            $table->dateTime('tanggal_pemesanan');
            $table->decimal('total_belanja', 15, 2);
            $table->decimal('biaya_pengiriman', 15, 2);
            $table->decimal('diskon_voucher', 15, 2)->default(0);
            $table->decimal('total_tagihan', 15, 2);
            $table->string('metode_pembayaran');
            $table->text('alamat_pengiriman');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status_pesanan', ['Menunggu Konfirmasi', 'Disiapkan', 'Mencari Kurir', 'Sedang Dikirim', 'Diterima', 'Gagal Kirim']);
            $table->dateTime('estimasi_tiba')->nullable();
            $table->string('bukti_pengiriman')->nullable();
            $table->text('alasan_gagal')->nullable();
            $table->decimal('potongan_driver', 15, 2)->default(0);
            $table->integer('review_rating')->nullable();
            $table->text('review_text')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->string('snap_token')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};

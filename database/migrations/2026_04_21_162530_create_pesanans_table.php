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
        if (!Schema::hasTable('pesanans')) {
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
                $table->enum('status_pesanan', ['menunggu', 'diambil', 'dalam_pengiriman', 'diterima', 'gagal_kirim']);
                $table->dateTime('estimasi_tiba')->nullable();
                $table->string('bukti_pengiriman')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};

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
        Schema::create('history_produks', function (Blueprint $table) {
            $table->id('id_history');
            $table->unsignedBigInteger('id_produk');
            $table->decimal('harga_reguler_lama', 10, 2)->nullable();
            $table->decimal('harga_reguler_baru', 10, 2);
            $table->decimal('harga_member_lama', 10, 2)->nullable();
            $table->decimal('harga_member_baru', 10, 2);
            $table->foreignId('id_admin_cabang')->constrained('admin_cabangs', 'id_admin_cabang')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_produks');
    }
};
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
        Schema::create('admin_cabangs', function (Blueprint $table) {
            $table->id('id_admin_cabang');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_cabang');
            $table->decimal('gaji', 15, 2)->default(0);
            $table->date('tanggal_masuk')->nullable();
            $table->string('status_karyawan')->default('Aktif');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_cabangs');
    }
};

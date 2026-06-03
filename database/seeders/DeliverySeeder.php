<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add some test deliveries with different statuses
        DB::table('pesanans')->insert([
            // Pending delivery 1 (FCFS Queue)
            [
                'id_pelanggan' => 1,
                'id_cabang' => 1,
                'id_kurir' => null, // Must be null for FCFS
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now(),
                'total_belanja' => 500000,
                'biaya_pengiriman' => 25000,
                'diskon_voucher' => 0,
                'total_tagihan' => 525000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. Gatot Subroto No. 123, Jakarta',
                'status_pesanan' => 'Menunggu Konfirmasi', // Correct ENUM
                'estimasi_tiba' => Carbon::now()->addHours(2),
                'latitude' => -6.2087,
                'longitude' => 106.8456,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Pending delivery 2 (FCFS Queue)
            [
                'id_pelanggan' => 2,
                'id_cabang' => 1,
                'id_kurir' => null,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now(),
                'total_belanja' => 200000,
                'biaya_pengiriman' => 15000,
                'diskon_voucher' => 0,
                'total_tagihan' => 215000,
                'metode_pembayaran' => 'Cash',
                'alamat_pengiriman' => 'Jl. Diponegoro No. 45, Bandung',
                'status_pesanan' => 'Menunggu Konfirmasi',
                'estimasi_tiba' => Carbon::now()->addHours(1),
                'latitude' => -6.9025,
                'longitude' => 107.6186,
                'created_at' => Carbon::now()->subMinutes(10),
                'updated_at' => Carbon::now()->subMinutes(10),
            ],
            // Pending delivery 3 (FCFS Queue)
            [
                'id_pelanggan' => 3,
                'id_cabang' => 1,
                'id_kurir' => null,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now(),
                'total_belanja' => 850000,
                'biaya_pengiriman' => 35000,
                'diskon_voucher' => 0,
                'total_tagihan' => 885000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. Braga No. 10, Bandung',
                'status_pesanan' => 'Menunggu Konfirmasi',
                'estimasi_tiba' => Carbon::now()->addHours(3),
                'latitude' => -6.9175,
                'longitude' => 107.6090,
                'created_at' => Carbon::now()->subMinutes(25),
                'updated_at' => Carbon::now()->subMinutes(25),
            ],
            // Confirmed delivery (in active tasks for kurir 1)
            [
                'id_pelanggan' => 2,
                'id_cabang' => 1,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now()->subHours(1),
                'total_belanja' => 750000,
                'biaya_pengiriman' => 30000,
                'diskon_voucher' => 50000,
                'total_tagihan' => 730000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. M.H. Thamrin No. 456, Jakarta',
                'status_pesanan' => 'Mencari Kurir', // Correct ENUM
                'estimasi_tiba' => Carbon::now()->addHours(3),
                'latitude' => -6.1971,
                'longitude' => 106.8226,
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
            // In delivery
            [
                'id_pelanggan' => 3,
                'id_cabang' => 1,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now()->subHours(4),
                'total_belanja' => 1000000,
                'biaya_pengiriman' => 40000,
                'diskon_voucher' => 100000,
                'total_tagihan' => 940000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. Sudirman No. 789, Jakarta',
                'status_pesanan' => 'Sedang Dikirim',
                'estimasi_tiba' => Carbon::now()->addMinutes(45),
                'latitude' => -6.2207,
                'longitude' => 106.8005,
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subMinutes(15),
            ],
            // Completed delivery
            [
                'id_pelanggan' => 4,
                'id_cabang' => 1,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now()->subDay(),
                'total_belanja' => 450000,
                'biaya_pengiriman' => 20000,
                'diskon_voucher' => 0,
                'total_tagihan' => 470000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. Jendral Sudirman No. 200, Bandung',
                'status_pesanan' => 'Diterima',
                'estimasi_tiba' => Carbon::now()->subHours(2),
                'latitude' => -6.9271,
                'longitude' => 107.6412,
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            // Failed delivery
            [
                'id_pelanggan' => 5,
                'id_cabang' => 1,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now()->subDays(2),
                'total_belanja' => 600000,
                'biaya_pengiriman' => 30000,
                'diskon_voucher' => 0,
                'total_tagihan' => 630000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. Ahmad Yani No. 300, Bandung',
                'status_pesanan' => 'Gagal Kirim',
                'estimasi_tiba' => Carbon::now()->subDay(),
                'latitude' => -6.9150,
                'longitude' => 107.6320,
                'alasan_gagal' => 'Customer tidak ada di lokasi pada waktu pengiriman',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDay(),
            ],
            // Rejected delivery
            [
                'id_pelanggan' => 6,
                'id_cabang' => 1,
                'id_kurir' => 1,
                'id_promo' => null,
                'tanggal_pemesanan' => Carbon::now()->subDays(3),
                'total_belanja' => 550000,
                'biaya_pengiriman' => 25000,
                'diskon_voucher' => 25000,
                'total_tagihan' => 550000,
                'metode_pembayaran' => 'Transfer Bank',
                'alamat_pengiriman' => 'Jl. Raya Cikampek No. 150, Karawang',
                'status_pesanan' => 'Gagal Kirim',
                'estimasi_tiba' => Carbon::now()->subDays(2),
                'latitude' => -6.3050,
                'longitude' => 107.4870,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ]);

        // Create tracking records for these deliveries
        DB::table('pengiriman_tracking')->insert([
            // Pending delivery tracking
            [
                'id_pesanan' => 1,
                'status' => 'pending',
                'keterangan' => 'Pesanan baru menunggu konfirmasi driver',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Confirmed delivery tracking
            [
                'id_pesanan' => 2,
                'status' => 'pending',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'id_pesanan' => 2,
                'status' => 'diterima_driver',
                'keterangan' => 'Driver telah mengkonfirmasi pengiriman',
                'created_at' => Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],
            // In delivery tracking
            [
                'id_pesanan' => 3,
                'status' => 'pending',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subHours(4),
                'updated_at' => Carbon::now()->subHours(4),
            ],
            [
                'id_pesanan' => 3,
                'status' => 'diterima_driver',
                'keterangan' => 'Driver telah mengkonfirmasi pengiriman',
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
            [
                'id_pesanan' => 3,
                'status' => 'diambil',
                'keterangan' => 'Barang telah diambil dari gudang',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            [
                'id_pesanan' => 3,
                'status' => 'dalam_pengiriman',
                'keterangan' => 'Barang sedang dalam perjalanan ke customer',
                'created_at' => Carbon::now()->subMinutes(45),
                'updated_at' => Carbon::now()->subMinutes(45),
            ],
            // Completed delivery tracking
            [
                'id_pesanan' => 4,
                'status' => 'pending',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'id_pesanan' => 4,
                'status' => 'diterima_driver',
                'keterangan' => 'Driver telah mengkonfirmasi pengiriman',
                'created_at' => Carbon::now()->subDay()->addHours(1),
                'updated_at' => Carbon::now()->subDay()->addHours(1),
            ],
            [
                'id_pesanan' => 4,
                'status' => 'diambil',
                'keterangan' => 'Barang telah diambil dari gudang',
                'created_at' => Carbon::now()->subDay()->addHours(2),
                'updated_at' => Carbon::now()->subDay()->addHours(2),
            ],
            [
                'id_pesanan' => 4,
                'status' => 'dalam_pengiriman',
                'keterangan' => 'Barang sedang dalam perjalanan',
                'created_at' => Carbon::now()->subDay()->addHours(3),
                'updated_at' => Carbon::now()->subDay()->addHours(3),
            ],
            [
                'id_pesanan' => 4,
                'status' => 'diterima',
                'keterangan' => 'Pesanan diterima customer dengan bukti foto',
                'created_at' => Carbon::now()->subHours(2),
                'updated_at' => Carbon::now()->subHours(2),
            ],
            // Failed delivery tracking
            [
                'id_pesanan' => 5,
                'status' => 'pending',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id_pesanan' => 5,
                'status' => 'diterima_driver',
                'keterangan' => 'Driver telah mengkonfirmasi pengiriman',
                'created_at' => Carbon::now()->subDays(2)->addHours(1),
                'updated_at' => Carbon::now()->subDays(2)->addHours(1),
            ],
            [
                'id_pesanan' => 5,
                'status' => 'gagal',
                'keterangan' => 'Customer tidak ada di lokasi pada waktu pengiriman',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            // Rejected delivery tracking
            [
                'id_pesanan' => 6,
                'status' => 'pending',
                'keterangan' => 'Pesanan baru',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'id_pesanan' => 6,
                'status' => 'ditolak_driver',
                'keterangan' => 'Driver menolak pengiriman: Alamat tidak sesuai dan lokasi terlalu jauh',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ]);

        // Create rejection record for rejected delivery
        DB::table('penolakan_pengiriman')->insert([
            [
                'id_pesanan' => 6,
                'id_kurir' => 1,
                'alasan' => 'Alamat tidak sesuai dan lokasi terlalu jauh dari rute pengiriman utama',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ]);
    }
}

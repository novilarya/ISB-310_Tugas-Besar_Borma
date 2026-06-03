<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminCabangSeeder extends Seeder
{
    /**
     * Seed data cabang, admin user, dan beberapa produk contoh.
     */
    public function run(): void
    {
        // 1. Seed Cabang
        $cabangAntapani = DB::table('cabangs')->insertGetId([
            'nama_cabang' => 'Borma Antapani',
            'alamat_cabang' => 'Jl. Terusan Jakarta No. 155, Antapani, Bandung',
            'koordinat_gps' => '-6.9147,107.6529',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cabangDago = DB::table('cabangs')->insertGetId([
            'nama_cabang' => 'Borma Dago',
            'alamat_cabang' => 'Jl. Ir. H. Djuanda No. 53, Dago, Bandung',
            'koordinat_gps' => '-6.8835,107.6174',
            'status' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Seed Admin User
        $adminAntapaniId = DB::table('users')->insertGetId([
            'nama' => 'Admin Antapani',
            'email' => 'admin.antapani@borma.co.id',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567890',
            'role' => 'Admin Cabang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminDagoId = DB::table('users')->insertGetId([
            'nama' => 'Admin Dago',
            'email' => 'admin.dago@borma.co.id',
            'password' => Hash::make('password'),
            'no_telepon' => '081298765432',
            'role' => 'Admin Cabang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan ke tabel admin_cabangs untuk relasi Multi-Admin -> Cabang
        $adminCabangAntapaniId = DB::table('admin_cabangs')->insertGetId([
            'id_user' => $adminAntapaniId,
            'id_cabang' => $cabangAntapani,
            'tanggal_masuk' => now()->subMonths(12),
            'status_karyawan' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $adminCabangDagoId = DB::table('admin_cabangs')->insertGetId([
            'id_user' => $adminDagoId,
            'id_cabang' => $cabangDago,
            'tanggal_masuk' => now()->subMonths(8),
            'status_karyawan' => 'Aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Seed Produk Master
        $produk1 = DB::table('produks')->insertGetId([
            'nama_produk' => 'Minyak Goreng Bimoli 2L',
            'kategori' => 'Kebutuhan Pokok',
            'deskripsi' => 'Minyak goreng berkualitas tinggi dari kelapa sawit pilihan. Menghasilkan gorengan renyah dan sehat untuk keluarga.',
            'harga_reguler' => 34500,
            'harga_member' => 33800, // Diskon 700 (2.03%) - range 1%-2.5% (345 - 862.5)
            'gambar_produk' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $produk2 = DB::table('produks')->insertGetId([
            'nama_produk' => 'Beras Pandan Wangi 5kg',
            'kategori' => 'Kebutuhan Pokok',
            'deskripsi' => 'Beras pandan wangi premium kualitas terbaik. Nasi pulen dan beraroma harum alami.',
            'harga_reguler' => 75000,
            'harga_member' => 73000, // Diskon 2000 (Flat) - range 1000 - 2500
            'gambar_produk' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $produk3 = DB::table('produks')->insertGetId([
            'nama_produk' => 'Susu UHT Full Cream 1L',
            'kategori' => 'Minuman',
            'deskripsi' => 'Susu UHT full cream segar, cocok untuk segala usia. Kaya kalsium dan vitamin D.',
            'harga_reguler' => 18500,
            'harga_member' => 18100, // Diskon 400 (2.16%) - range 1%-2.5% (185 - 462.5)
            'gambar_produk' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $produk4 = DB::table('produks')->insertGetId([
            'nama_produk' => 'Sabun Cuci Piring Sunlight Refill 800ml',
            'kategori' => 'Kebersihan',
            'deskripsi' => 'Sabun cuci piring dengan formula anti-bakteri. Efektif membersihkan lemak dan noda membandel.',
            'harga_reguler' => 15500,
            'harga_member' => 15200, // Diskon 300 (1.94%) - range 1%-2.5% (155 - 387.5)
            'gambar_produk' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $produk5 = DB::table('produks')->insertGetId([
            'nama_produk' => 'Chitato Lite Rasa Sapi Panggang 68g',
            'kategori' => 'Snack',
            'deskripsi' => 'Keripik kentang ringan dengan rasa sapi panggang yang gurih. Camilan favorit keluarga.',
            'harga_reguler' => 12000,
            'harga_member' => 11800, // Diskon 200 (1.67%) - range 1%-2.5% (120 - 300)
            'gambar_produk' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $produk6 = DB::table('produks')->insertGetId([
            'nama_produk' => 'Teh Pucuk Harum 500ml',
            'kategori' => 'Minuman',
            'deskripsi' => 'Teh pucuk harum yang segar dan nikmat. Dari daun teh pucuk pilihan.',
            'harga_reguler' => 4500,
            'harga_member' => 4400, // Diskon 100 (2.22%) - range 1%-2.5% (45 - 112.5)
            'gambar_produk' => 'default.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Seed Produk Cabang (stok per cabang — ini yang tampil di admin)
        // Cabang Antapani
        DB::table('produk_cabangs')->insert([
            ['id_produk' => $produk1, 'id_cabang' => $cabangAntapani, 'jumlah_stok' => 150, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => $produk2, 'id_cabang' => $cabangAntapani, 'jumlah_stok' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => $produk3, 'id_cabang' => $cabangAntapani, 'jumlah_stok' => 84, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => $produk4, 'id_cabang' => $cabangAntapani, 'jumlah_stok' => 240, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => $produk5, 'id_cabang' => $cabangAntapani, 'jumlah_stok' => 65, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Cabang Dago — produk beda stoknya
        DB::table('produk_cabangs')->insert([
            ['id_produk' => $produk1, 'id_cabang' => $cabangDago, 'jumlah_stok' => 90, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => $produk3, 'id_cabang' => $cabangDago, 'jumlah_stok' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => $produk6, 'id_cabang' => $cabangDago, 'jumlah_stok' => 200, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Seed History Harga awal
        DB::table('history_produks')->insert([
            ['id_produk' => $produk1, 'harga_reguler_lama' => null, 'harga_reguler_baru' => 34500, 'harga_member_lama' => null, 'harga_member_baru' => 33800, 'id_admin_cabang' => $adminCabangAntapaniId, 'created_at' => now()->subMonths(2), 'updated_at' => now()->subMonths(2)],
            ['id_produk' => $produk1, 'harga_reguler_lama' => 33000, 'harga_reguler_baru' => 34500, 'harga_member_lama' => 32340, 'harga_member_baru' => 33800, 'id_admin_cabang' => $adminCabangAntapaniId, 'created_at' => now()->subDays(15), 'updated_at' => now()->subDays(15)],
            ['id_produk' => $produk2, 'harga_reguler_lama' => null, 'harga_reguler_baru' => 75000, 'harga_member_lama' => null, 'harga_member_baru' => 73000, 'id_admin_cabang' => $adminCabangAntapaniId, 'created_at' => now()->subMonths(3), 'updated_at' => now()->subMonths(3)],
        ]);
    }
}

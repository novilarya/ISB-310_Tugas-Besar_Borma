<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'id_user' => 1,
                'nama' => 'Super Admin 1',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567891',
                'role' => 'Admin Super',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user' => 2,
                'nama' => 'Admin Cabang 1',
                'email' => 'admincabang@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567892',
                'role' => 'Admin Cabang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user' => 3,
                'nama' => 'Kurir 1',
                'email' => 'kurir@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567893',
                'role' => 'Kurir',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id_user' => 4,
                'nama' => 'Agus Lele',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'no_telepon' => '081234567894',
                'role' => 'Pelanggan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
        
        $this->call([
            AdminCabangSeeder::class, // cabang, admin user, produk, stok
            OrderSeeder::class,       // pelanggan, kurir, pesanan, items
            PromoSeeder::class,       // promo & voucher

        ]);

        DB::table('pelanggans')->insert([
            [
                'id_user' => 4,
                'status_member' => 1,
                'poin_member' => 100,
                'provinsi' => 'Jawa Barat',
                'kota_kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Cibeunying Kaler',
                'alamat' => 'Jalan Gagak No 132', 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        DB::table('cabangs')->insert([
            [
                'nama_cabang' => 'Borma Gempol',
                'alamat_cabang' => 'Jl. Gempol Sari No. 83',
                'koordinat_gps' => '-6.950396317796121, 107.57854452904492',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Borma Buah Batu',
                'alamat_cabang' => 'Jl. Buah Batu No. 225',
                'koordinat_gps' => '-6.955822369884887, 107.63231204501615',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Borma Cijerah',
                'alamat_cabang' => 'Jl. Cijerah No. 100',
                'koordinat_gps' => '-6.935190682604853, 107.54584255435934',  
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Borma Cikutra',
                'alamat_cabang' => 'Jl. Cikutra No. 186',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Borma Kerkof',
                'alamat_cabang' => 'Jl. Kerkof No. 186',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Banjaran',
                'alamat_cabang' => 'Jl. Raya Banjaran No. 100',
                'koordinat_gps' => '-7.092679391433424, 107.49744422882598',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Babakan Sari',
                'alamat_cabang' => 'Jl. Babakan Sari No. 100',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Ciparay',
                'alamat_cabang' => 'Jl. Ciparay No. 288',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Fresh Burangrang',
                'alamat_cabang' => 'Jl. Burangrang No. 195',
                'koordinat_gps' => '-6.923449815611088, 107.61130913025827',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Fresh Garuda',
                'alamat_cabang' => 'Jl. Garuda No. 210',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Fresh Mekarwangi',
                'alamat_cabang' => 'Jl. Mekarwangi No. 100',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Fresh Perintis',
                'alamat_cabang' => 'Jl. Perintis Kemerdekaan No. 210',
                'koordinat_gps' => '-6.919538582489261, 107.6478291494488',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Prama Leles',
                'alamat_cabang' => 'Jl. Raya Leles No. 200',
                'koordinat_gps' => '-7.02109051795237, 107.5757697995567',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_cabang' => 'Tikma Soreang',
                'alamat_cabang' => 'Jl. Raya Soreang No. 200',
                'koordinat_gps' => '-7.019687167687294, 107.48242338733801',
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        DB::table('admin_cabangs')->insert([
            [
                'id_user' => 2,
                'id_cabang' => 1,
                'tanggal_masuk' => Carbon::now(),
                'status_karyawan' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}

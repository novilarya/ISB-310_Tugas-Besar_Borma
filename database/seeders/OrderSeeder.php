<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Pelanggan Users ───────────────────────────────────────────
        $users = [
            ['nama' => 'Budi Santoso',    'email' => 'budi@example.com',   'no_telepon' => '081234567890'],
            ['nama' => 'Siti Aminah',     'email' => 'siti@example.com',   'no_telepon' => '085678901234'],
            ['nama' => 'Andi Wijaya',     'email' => 'andi@example.com',   'no_telepon' => '089911223344'],
            ['nama' => 'Dewi Lestari',    'email' => 'dewi@example.com',   'no_telepon' => '081355667788'],
            ['nama' => 'Rudi Hartono',    'email' => 'rudi@example.com',   'no_telepon' => '081399001122'],
        ];
        $userIds = [];
        foreach ($users as $u) {
            $userIds[] = DB::table('users')->insertGetId(array_merge($u, [
                'password'   => bcrypt('password123'),
                'role'       => 'Pelanggan',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ── 2. Pelanggans ────────────────────────────────────────────────
        $pelangganData = [
            ['status_member' => false, 'poin_member' => 0,   'alamat' => 'Jl. Antapani No. 1, Bandung', 'provinsi' => 'Jawa Barat', 'kota_kabupaten' => 'Bandung', 'kecamatan' => 'Antapani'],
            ['status_member' => true,  'poin_member' => 350, 'alamat' => 'Jl. Dago No. 2, Bandung', 'provinsi' => 'Jawa Barat', 'kota_kabupaten' => 'Bandung', 'kecamatan' => 'Coblong'],
            ['status_member' => false, 'poin_member' => 0,   'alamat' => 'Jl. Kiaracondong No. 3, Bandung', 'provinsi' => 'Jawa Barat', 'kota_kabupaten' => 'Bandung', 'kecamatan' => 'Kiaracondong'],
            ['status_member' => true,  'poin_member' => 120, 'alamat' => 'Jl. Cicadas No. 5, Bandung', 'provinsi' => 'Jawa Barat', 'kota_kabupaten' => 'Bandung', 'kecamatan' => 'Rancasari'],
            ['status_member' => true,  'poin_member' => 80,  'alamat' => 'Jl. Margahayu No. 8, Bandung', 'provinsi' => 'Jawa Barat', 'kota_kabupaten' => 'Bandung', 'kecamatan' => 'Mandalajati'],
        ];
        $pelangganIds = [];
        foreach ($pelangganData as $i => $p) {
            $pelangganIds[] = DB::table('pelanggans')->insertGetId(array_merge($p, [
                'id_user'    => $userIds[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // ── 3. Kurir ─────────────────────────────────────────────────────
        $kurirUsers = [
            ['nama' => 'Asep Kurir', 'email' => 'asep.kurir@borma.co.id', 'kendaraan' => 'Motor Honda Beat',   'warna' => 'Hitam', 'plat' => 'D 1234 ABC', 'id_cabang' => 1],
            ['nama' => 'Budi Kurir', 'email' => 'budi.kurir@borma.co.id', 'kendaraan' => 'Motor Yamaha NMAX', 'warna' => 'Putih', 'plat' => 'D 5678 DEF', 'id_cabang' => 2],
        ];
        $kurirIds = [];
        foreach ($kurirUsers as $k) {
            $uid = DB::table('users')->insertGetId([
                'nama' => $k['nama'], 'email' => $k['email'],
                'password' => bcrypt('password123'), 'no_telepon' => '08100000000',
                'role' => 'Kurir', 'created_at' => now(), 'updated_at' => now(),
            ]);
            $kurirIds[] = DB::table('kurirs')->insertGetId([
                'id_user' => $uid,
                'kendaraan' => $k['kendaraan'],
                'warna_kendaraan' => $k['warna'],
                'plat_nomor' => $k['plat'],
                'id_cabang' => $k['id_cabang'],
                'pendapatan_pengiriman' => 0,
                
                'status_mengirim' => 'Tidak Mengirim',
                'status_aktif' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── 4. Pesanan — 7 hari terakhir untuk chart trend ──────────────
        // [hari_lalu, pelanggan_idx, status, total_belanja, biaya_kirim, metode]
        $pesananData = [
            // Hari ini
            [0, 0, 'Menunggu Konfirmasi', 110000, 15000, 'Transfer Bank'],
            [0, 1, 'Disiapkan',     320500, 20000, 'E-Wallet'],
            [0, 2, 'Sedang Dikirim', 74500, 15000, 'COD'],
            // Kemarin
            [1, 0, 'Diterima',      435000, 15000, 'Transfer Bank'],
            [1, 3, 'Diterima',       88000, 10000, 'E-Wallet'],
            // 2 hari lalu
            [2, 1, 'Diterima',      215000, 15000, 'COD'],
            [2, 4, 'Diterima',       55000, 10000, 'Transfer Bank'],
            [2, 2, 'Diterima',      178000, 15000, 'E-Wallet'],
            // 3 hari lalu
            [3, 0, 'Diterima',      340000, 20000, 'Transfer Bank'],
            [3, 3, 'Diterima',       92500, 15000, 'COD'],
            // 4 hari lalu
            [4, 1, 'Diterima',      128000, 10000, 'E-Wallet'],
            [4, 4, 'Diterima',      267000, 15000, 'Transfer Bank'],
            // 5 hari lalu
            [5, 2, 'Diterima',       56000, 10000, 'COD'],
            [5, 0, 'Diterima',      412000, 20000, 'Transfer Bank'],
            // 6 hari lalu
            [6, 3, 'Diterima',      185000, 15000, 'E-Wallet'],
            [6, 1, 'Diterima',       99000, 10000, 'COD'],
        ];

        $pesananIds = [];
        foreach ($pesananData as [$hariLalu, $pelIdx, $status, $belanja, $kirim, $metode]) {
            $ts = Carbon::today()->subDays($hariLalu)->setTime(rand(8, 20), rand(0, 59));
            $kurirId = ($status === 'Sedang Dikirim' || $status === 'Diterima') ? $kurirIds[array_rand($kurirIds)] : null;
            $pesananIds[] = DB::table('pesanans')->insertGetId([
                'id_pelanggan'     => $pelangganIds[$pelIdx],
                'id_cabang'        => rand(1, 2),
                'id_kurir'         => $kurirId,
                'id_promo'         => null,
                'tanggal_pemesanan'=> $ts,
                'total_belanja'    => $belanja,
                'biaya_pengiriman' => $kirim,
                'diskon_voucher'   => 0,
                'total_tagihan'    => $belanja + $kirim,
                'metode_pembayaran'=> $metode,
                'alamat_pengiriman'=> $pelangganData[$pelIdx]['alamat'],
                'status_pesanan'   => $status,
                'estimasi_tiba'    => $status !== 'Menunggu Konfirmasi' ? $ts->copy()->addHours(2) : null,
                'bukti_pengiriman' => $status === 'Diterima' ? 'bukti_kirim.jpg' : null,
                'created_at'       => $ts,
                'updated_at'       => $ts,
            ]);
        }

        // ── 5. Detail Items (pesanan_produks) ────────────────────────────
        // Produk IDs: 1=MinyakGoreng, 2=Beras, 3=Susu, 4=Sabun, 5=Chitato
        $itemTemplates = [
            [1, 2, 34500],   // 2x Minyak Goreng
            [2, 1, 75000],   // 1x Beras
            [3, 3, 18500],   // 3x Susu
            [4, 4, 15500],   // 4x Sabun
            [5, 5, 12000],   // 5x Chitato
        ];

        foreach ($pesananIds as $idx => $pid) {
            $tpl = $itemTemplates[$idx % count($itemTemplates)];
            [$prodId, $qty, $harga] = $tpl;
            DB::table('pesanan_produks')->insert([
                'id_pesanan'    => $pid,
                'id_produk'     => $prodId,
                'jumlah'        => $qty,
                'harga_satuan'  => $harga,
                'subtotal'      => $harga * $qty,
                'catatan_produk'=> null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
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
            ]
        ]);
    }
}

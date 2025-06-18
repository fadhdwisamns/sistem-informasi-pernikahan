<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->delete();

         User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'), // password default: password
            'role' => 'admin',
            'kua_id' => null,
            'pa_id' => null,
        ]);

         User::create([
            'name' => 'Petugas KUA Kuantan Tengah',
            'username' => 'petugaskua1',
            'password' => Hash::make('password'),
            'role' => 'petugas_kua',
            'kua_id' => 1, // Pastikan ID ini ada di tabel master_kua
            'pa_id' => null,
        ]);

         User::create([
            'name' => 'Petugas PA Teluk Kuantan',
            'username' => 'petugaspa1',
            'password' => Hash::make('password'),
            'role' => 'petugas_pa',
            'kua_id' => null,
            'pa_id' => 1, // Pastikan ID ini ada di tabel master_pa
        ]);
    }
}

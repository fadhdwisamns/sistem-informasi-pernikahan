<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_kua')->delete();
        DB::table('master_pa')->delete();

        DB::table('master_kua')->insert([
            ['nama_kua' => 'KUA Kecamatan Kuantan Tengah', 'alamat' => 'Jl. Proklamasi No. 1, Teluk Kuantan'],
            ['nama_kua' => 'KUA Kecamatan Singingi', 'alamat' => 'Jl. Raya Muara Lembu'],
            ['nama_kua' => 'KUA Kecamatan Benai', 'alamat' => 'Jl. Jenderal Sudirman, Benai'],
            ['nama_kua' => 'KUA Kecamatan Hulu Kuantan', 'alamat' => 'Jl. Poros Lubuk Jambi'],
        ]);

         DB::table('master_pa')->insert([
            ['nama_pa' => 'Pengadilan Agama Teluk Kuantan', 'alamat' => 'Jl. Komplek Perkantoran Pemda'],
        ]);
    }
}

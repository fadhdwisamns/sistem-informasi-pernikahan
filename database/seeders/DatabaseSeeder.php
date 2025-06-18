<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MasterDataSeeder::class,
            UserSeeder::class,
        ]);

         if (app()->environment('local')) {
            $this->call(DummyDataSeeder::class);
        }
    }
}

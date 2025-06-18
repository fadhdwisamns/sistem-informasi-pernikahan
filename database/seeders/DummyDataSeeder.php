<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\Pernikahan;
use App\Models\Perceraian;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pernikahan::query()->delete();
        Perceraian::query()->delete();

        Pernikahan::factory()->count(100)->create();
        Perceraian::factory()->count(30)->create();
    }
}

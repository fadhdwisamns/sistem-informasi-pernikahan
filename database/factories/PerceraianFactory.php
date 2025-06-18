<?php

namespace Database\Factories;
use App\Models\Pernikahan;
use App\Models\Perceraian;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perceraian>
 */
class PerceraianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'pa_id' => 1, // Asumsi hanya ada 1 PA
            'no_putusan' => 'Pdt.G/' . $this->faker->unique()->numerify('####/Pa.Tlk'),
            'tanggal_putusan' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'nama_penggugat' => $this->faker->name(),
            'nama_tergugat' => $this->faker->name(),
            'status_verifikasi' => $this->faker->randomElement(['menunggu', 'disetujui']),
            'catatan_verifikasi' => null,
            'created_by' => 3, // Diinput oleh user Petugas PA dengan ID 3
            'verified_by' => 1, // Diverifikasi oleh user Admin dengan ID 1
        ];
    }
}

<?php

namespace Database\Factories;
use App\Models\Pernikahan;
use App\Models\Perceraian;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pernikahan>
 */
class PernikahanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kua_id' => $this->faker->numberBetween(1, 4), // Asumsi ada 4 KUA
            'jenis_data' => $this->faker->randomElement(['pernikahan', 'rujuk']),
            'no_akta' => 'K.' . $this->faker->unique()->numerify('#####/##/VI/####'),
            'tanggal_akad' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'nama_suami' => $this->faker->name('male'),
            'nik_suami' => $this->faker->numerify('################'), // <-- 16 Tanda Pagar
            
            'tempat_lahir_suami' => $this->faker->city(),
            'tanggal_lahir_suami' => $this->faker->date(),
            'nama_istri' => $this->faker->name('female'),
            'nik_istri' => $this->faker->numerify('################'), // <-- 16 Tanda Pagar     
            'tempat_lahir_istri' => $this->faker->city(),
            'tanggal_lahir_istri' => $this->faker->date(),
            'status_verifikasi' => $this->faker->randomElement(['menunggu', 'disetujui', 'ditolak']),
            'catatan_verifikasi' => null,
            'created_by' => 2, // Diinput oleh user Petugas KUA dengan ID 2
            'verified_by' => 1, // Diverifikasi oleh user Admin dengan ID 1
        ];
    }
}

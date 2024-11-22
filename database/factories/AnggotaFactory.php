<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_anggota' => $this->faker->name,                 // Nama anggota acak
            'alamat' => $this->faker->address,                    // Alamat acak
            'no_telepon' => $this->faker->phoneNumber,            // Nomor telepon acak
            'email' => $this->faker->unique()->safeEmail,         // Email unik acak

        ];
    }
}
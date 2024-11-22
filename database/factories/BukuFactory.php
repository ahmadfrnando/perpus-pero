<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{   
    protected $model = Buku::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul_buku' => $this->faker->sentence(3),              // Judul buku dengan 3 kata
            'penulis' => $this->faker->name,                        // Nama penulis
            'penerbit' => $this->faker->company,                    // Nama penerbit
            'tahun_terbit' => $this->faker->year,                   // Tahun terbit
            'isbn' => $this->faker->isbn13,                         // Nomor ISBN
            'stok' => $this->faker->numberBetween(1, 50),           // Jumlah stok antara 1 hingga 50
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengembalian>
 */
class PengembalianFactory extends Factory
{
    public function definition(): array
    {
        // Pilih peminjaman dengan status "dipinjam" secara acak
        $peminjaman = Peminjaman::where('status', 'dipinjam')->inRandomOrder()->first();

        return [
            'peminjaman_id' => $peminjaman ? $peminjaman->id : null, // Memastikan ada peminjaman_id yang valid
            'tanggal_pengembalian' => Carbon::now(), // Tanggal pengembalian saat ini
            'denda' => $this->faker->randomFloat(2, 0, 100000), // Denda acak antara 0 dan 100.000
        ];
    }
}
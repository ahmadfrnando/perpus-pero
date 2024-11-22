<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{   
    protected $model = Peminjaman::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPinjam = Carbon::now();  // Set tanggal pinjam ke tanggal saat ini
        $tanggalKembali = (clone $tanggalPinjam)->addDays(7);  // Set tanggal kembali 7 hari setelah tanggal pinjam

        return [
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'buku_id' => Buku::factory(),         // Menggunakan factory Buku untuk mendapatkan buku_id
            'anggota_id' => Anggota::factory(),   // Menggunakan factory Anggota untuk mendapatkan anggota_id
        ];
    }
}
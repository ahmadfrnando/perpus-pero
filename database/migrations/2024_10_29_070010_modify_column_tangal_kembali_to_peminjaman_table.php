<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_kembali')->after('tanggal_pinjam');
            $table->dropColumn('tangal_kembali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tangal_kembali')->after('tanggal_pinjam');
            $table->dropColumn('tanggal_kembali');
        });
    }
};
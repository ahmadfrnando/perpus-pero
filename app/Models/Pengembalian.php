<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalian';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($pengembalian) {
            $pengembalian->peminjaman()->update(['status' => 'dikembalikan']);
        });
        
        static::deleted(function ($pengembalian) {
            $pengembalian->peminjaman()->update(['status' => 'dipinjam']);
        });
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
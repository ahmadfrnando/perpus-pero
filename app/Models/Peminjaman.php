<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{   
    use HasFactory;
    protected $table = 'peminjaman';

    protected $guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
    
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}
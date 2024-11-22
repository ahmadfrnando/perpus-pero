<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;

class BukuExport implements FromCollection
{
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($tanggal_awal, $tanggal_akhir)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function collection()
    {
        return Buku::whereBetween('created_at', [$this->tanggal_awal, $this->tanggal_akhir])->get();
        dd($this->tanggal_awal, $this->tanggal_akhir);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Buku',
            'Penulis',
            'Penerbit',
            'Tahun Terbit',
            'ISBN',
            'Stok',
            'Tanggal Dibuat',
            'Tanggal Diupdate',
        ];
    }
}
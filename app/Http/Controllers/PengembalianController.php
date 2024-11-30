<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PengembalianController extends Controller
{
    public function scan(Request $request)
    {
        try {
            $getCode = $request->input('code');


            $data = Peminjaman::where('code', $getCode)
                ->join('buku', 'buku.id', '=', 'peminjaman.buku_id')
                ->join('anggota', 'anggota.id', '=', 'peminjaman.anggota_id')
                ->select('peminjaman.id as peminjaman_id', 'buku.id as buku_id', 'anggota.id as anggota_id', 'buku.judul_buku', 'anggota.nama_anggota', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali')
                ->first();

            if ($data) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'nama_anggota' => $data->nama_anggota,
                        'judul_buku' => $data->judul_buku,
                        'tanggal_pinjam' => $data->tanggal_pinjam,
                        'tanggal_kembali' => $data->tanggal_kembali,
                        'peminjaman_id' => $data->peminjaman_id,
                        'tanggal_pengembaian' => now()
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        } catch (\Exception $e) {
            // Log the error message to the Laravel log file
            Log::error('Error scanning QR code: ' . $e->getMessage());

            // Return a response with a 500 status code and the error message
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required',
            'tanggal_pengembalian' => 'required|date',
            'denda' => 'required|numeric',
        ]);

        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $request->input('peminjaman_id'),
            'tanggal_pengembalian' => $request->input('tanggal_pengembalian'),
            'denda' => $request->input('denda'),
        ]);

        if ($pengembalian) {
            $peminjaman = Peminjaman::find($request->input('peminjaman_id'));
            $peminjaman->status = 'dikembalikan';
            $peminjaman->save();
        }

        return redirect()->back();
    }
}

<?php

namespace App\Observers;

use App\Models\Peminjaman;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PeminjamanObserver
{
    /**
     * Handle the Peminjaman "created" event.
     */
    public function creating(Peminjaman $peminjaman): void
    {
        $qrContent = $peminjaman->id ?? time(); 
        $qrFilename = md5($qrContent) . '.png';

        $qrImage = QrCode::format('png')->size(300)->margin(2)->errorCorrection('H')
        ->generate($qrContent);
        Storage::disk('public')->put('qrcodes/' . $qrFilename, $qrImage);
        $peminjaman->qrcode = $qrFilename;
        $peminjaman->code = $qrContent;
    }

    /**
     * Handle the Peminjaman "updated" event.
     */
    public function updated(Peminjaman $peminjaman): void
    {
        //
    }

    /**
     * Handle the Peminjaman "deleted" event.
     */
    public function deleted(Peminjaman $peminjaman): void
    {
        //
    }

    /**
     * Handle the Peminjaman "restored" event.
     */
    public function restored(Peminjaman $peminjaman): void
    {
        //
    }

    /**
     * Handle the Peminjaman "force deleted" event.
     */
    public function forceDeleted(Peminjaman $peminjaman): void
    {
        //
    }
}

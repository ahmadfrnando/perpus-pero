<?php

namespace App\Observers;

use App\Mail\MailNotify;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Mail;
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

        $id = Peminjaman::latest()->first()->id;
        Mail::to($peminjaman->anggota->email)->send(new MailNotify($id));
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

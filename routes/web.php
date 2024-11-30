<?php

use App\Filament\Pages\PengembalianByScan;
use App\Http\Controllers\KartuController;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengembalianController;

Route::get('/test', function () {
    return view('kartu-peminjaman');
});

Route::post('/barcode', [PengembalianController::class, 'scan'])->name('barcode.scan');
// Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');

Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
Route::get('/kartu-peminjaman/{id}', [KartuController::class, 'index']);
// Route::get('/pengembalian/scan/{code}', [PengembalianController::class, 'scan'])->name('pengembalian.scan');
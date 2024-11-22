<?php

namespace App\Filament\Resources\PengembalianResource\Pages;

use App\Filament\Resources\PengembalianResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePengembalians extends ManageRecords
{
    protected static string $resource = PengembalianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Pengembalian')->icon('heroicon-o-plus'),
        ];
    }
}
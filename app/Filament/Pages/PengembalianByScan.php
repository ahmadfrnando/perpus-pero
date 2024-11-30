<?php

namespace App\Filament\Pages;

use App\Models\Pengembalian;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class PengembalianByScan extends Page implements HasTable
{
    use InteractsWithTable;

    public ?array $data = [];

    protected static $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string $view = 'filament.pages.pengembalian-by-scan';
    protected static ?string $navigationLabel = 'Pengembalian';
    protected static ?int $navigationSort = 5;

    public function mount()
    {
        $this->form->fill();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Pengembalian::query())
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('peminjaman.buku.judul_buku')->searchable(),
                TextColumn::make('peminjaman.anggota.nama_anggota')->searchable(),
                TextColumn::make('tanggal_pengembalian')->date('d F Y'),
                TextColumn::make('denda')->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getFormActions()
    {
        return [
            Action::make('simpan')->submit('simpan'),
        ];
    }
}

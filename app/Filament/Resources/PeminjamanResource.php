<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Buku;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Peminjamaan';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal_pinjam')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->locale('id')
                    ->default(now())
                    ->required(),
                DatePicker::make('tanggal_kembali')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->locale('id')
                    ->required(),
                Select::make('buku_id')
                    ->label('Buku')
                    ->options(Buku::all()->pluck('judul_buku', 'id'))
                    ->searchable(),
                Select::make('anggota_id')
                    ->label('Anggota')
                    ->options(Buku::all()->pluck('nama_anggota', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anggota.nama_anggota')->searchable(),
                TextColumn::make('buku.judul_buku')->searchable()->wrap(),
                TextColumn::make('tanggal_pinjam')->searchable()->date('d F Y'),
                TextColumn::make('tanggal_kembali')->searchable()->date('d F Y'),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'dipinjam' => 'danger',
                        'dikembalikan' => 'success',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                    ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePeminjamen::route('/'),
        ];
    }
}
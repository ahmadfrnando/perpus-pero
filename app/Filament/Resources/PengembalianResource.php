<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Filament\Resources\PengembalianResource\RelationManagers;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;

class PengembalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Pengembalian';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('peminjaman_id')
                    ->label('Buku')
                    ->options(Peminjaman::where('status', 'dipinjam')->get()->pluck('buku.judul_buku', 'id'))
                    ->searchable()
                    ->required(),
                DatePicker::make('tanggal_pengembalian')
                    ->native(false)
                    ->displayFormat('d F Y')
                    ->locale('id')
                    ->default(now())
                    ->required(),
                TextInput::make('denda')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->prefix('Rp. '),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePengembalians::route('/'),
        ];
    }
}
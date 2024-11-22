<?php

namespace App\Filament\Pages;

use App\Models\Peminjaman;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;

class Laporan extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static string $view = 'filament.pages.laporan';

    protected static ?string $navigationLabel = 'Laporan';
    protected static ?int $navigationSort = 6;


    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('laporan')
                ->options([
                    'buku' => 'Data Buku',
                    'anggota' => 'Data Anggota',
                    'peminjaman' => 'Data Peminjaman',
                    'pengembalian' => 'Data Pengembalian',
                ]),
            DatePicker::make('tanggal_awal')
                ->native(false)
                ->label('Dari')
                ->displayFormat('d F Y')
                ->required()
                ->locale('id'),
            DatePicker::make('tanggal_akhir')
                ->native(false)
                ->label('Sampai')
                ->displayFormat('d F Y')
                ->required()
                ->default(now())
                ->locale('id')
        ])->columns(3)->statePath('data');
    }

    public function getFormActions()
    {
        return [
            Action::make('cetak')->submit('cetak'),
        ];
    }

    public function cetak()
    {
        try {
            $data = $this->form->getState();
            $model = $data['laporan'];
            $awal = $data['tanggal_awal'];
            $akhir = $data['tanggal_akhir'];

            switch ($model) {
                case 'buku':
                    return Excel::download(new BukuExport($awal, $akhir), 'data_buku.xlsx');
                case 'anggota':
                    // Tambahkan export untuk anggota
                    break;
                case 'peminjaman':
                    // Tambahkan export untuk peminjaman
                    break;
                case 'pengembalian':
                    // Tambahkan export untuk pengembalian
                    break;
                default:
                    throw new \Exception("Laporan tidak valid.");
            }
        } catch (Halt $ex) {
            return;
        }
    }
}
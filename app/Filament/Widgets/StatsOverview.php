<?php

namespace App\Filament\Widgets;

use App\Models\Anggota;
use App\Models\Buku;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Anggota', Anggota::count()),
            Stat::make('Total Buku', Buku::count()),
        ];
    }
}

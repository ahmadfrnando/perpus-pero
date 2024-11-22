<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Pengaturan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament.pages.pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Akun';
    protected static ?int $navigationSort = 7;
}
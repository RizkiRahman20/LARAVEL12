<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Peminjaman;
use App\Models\Stok;
use App\Models\User;

class StatistikDashboard extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Peminjaman', Peminjaman::count())
                ->description('Jumlah total peminjaman')
                ->icon('heroicon-o-clipboard')
                ->color('primary'),

            Card::make('Total Stok', Stok::sum('jumlah'))
                ->description('Jumlah barang dalam stok')
                ->icon('heroicon-o-archive-box')
                ->color('success'),

            Card::make('Total Anggota', User::count())
                ->description('Jumlah pengguna terdaftar')
                ->icon('heroicon-o-user-group')
                ->color('grey'),
        ];
    }
}

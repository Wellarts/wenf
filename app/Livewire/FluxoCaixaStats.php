<?php

namespace App\Livewire;

use App\Models\FluxoCaixa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FluxoCaixaStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Saldo', number_format(FluxoCaixa::all()->sum('valor'), 2, ",", "."))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('Débitos', number_format(FluxoCaixa::all()->where('valor', '<', 0)->sum('valor'), 2, ",", "."))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Crétidos', number_format(FluxoCaixa::all()->where('valor', '>', 0)->sum('valor'), 2, ",", "."))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}

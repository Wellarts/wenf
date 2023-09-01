<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ContasPagarStats extends BaseWidget
{
    protected function getStats(): array
    {
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        return [
            Stat::make('Total a Pagar', number_format(DB::table('contas_pagars')->where('status', 0)->sum('valor_parcela'),2, ",", "."))
                ->description('Todo Perído')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Total a Pagar', number_format(DB::table('contas_pagars')->where('status', 0)->whereYear('data_vencimento', $ano)->whereMonth('data_vencimento', $mes)->sum('valor_parcela'),2, ",", "."))
                ->description('Este mês')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Total a Pagar', number_format(DB::table('contas_pagars')->where('status', 0)->whereYear('data_vencimento', $ano)->whereMonth('data_vencimento', $mes)->whereDay('data_vencimento', $dia)->sum('valor_parcela'),2, ",", "."))
                ->description('Hoje')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
        ];
    }
}

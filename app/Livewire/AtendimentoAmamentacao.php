<?php

namespace App\Livewire;

use App\Models\Amamentacao;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AtendimentoAmamentacao extends ChartWidget
{
    protected static ?string $heading = 'Atendimentos de Amamentação';

    protected function getData(): array
    {
       $data = Trend::model(Amamentacao::class)
       ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Atendimentos por mês',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}


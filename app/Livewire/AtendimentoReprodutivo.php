<?php

namespace App\Livewire;

use App\Models\PlanejamentoReprodutivo;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AtendimentoReprodutivo extends ChartWidget
{
    protected static ?string $heading = 'Planejamentos Reprodutivos';

    protected function getData(): array
    {
       $data = Trend::model(PlanejamentoReprodutivo::class)
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

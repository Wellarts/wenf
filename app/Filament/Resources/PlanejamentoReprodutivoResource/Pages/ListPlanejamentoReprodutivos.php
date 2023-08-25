<?php

namespace App\Filament\Resources\PlanejamentoReprodutivoResource\Pages;

use App\Filament\Resources\PlanejamentoReprodutivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanejamentoReprodutivos extends ListRecords
{
    protected static string $resource = PlanejamentoReprodutivoResource::class;

    protected static ?string $title = 'Planejamentos Reprodutivos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo'),
        ];
    }
}

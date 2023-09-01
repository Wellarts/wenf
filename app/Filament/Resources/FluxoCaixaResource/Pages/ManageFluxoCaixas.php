<?php

namespace App\Filament\Resources\FluxoCaixaResource\Pages;

use App\Filament\Resources\FluxoCaixaResource;
use App\Livewire\FluxoCaixaStats;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFluxoCaixas extends ManageRecords
{
    protected static string $resource = FluxoCaixaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FluxoCaixaStats::class,
        ];
    }
}

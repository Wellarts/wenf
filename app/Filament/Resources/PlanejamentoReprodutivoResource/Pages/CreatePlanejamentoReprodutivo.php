<?php

namespace App\Filament\Resources\PlanejamentoReprodutivoResource\Pages;

use App\Filament\Resources\PlanejamentoReprodutivoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlanejamentoReprodutivo extends CreateRecord
{
     protected static ?string $title = 'Criar Planejamento Reprodutivo';

    protected static string $resource = PlanejamentoReprodutivoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\PlanejamentoReprodutivoResource\Pages;

use App\Filament\Resources\PlanejamentoReprodutivoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanejamentoReprodutivo extends EditRecord
{
    protected static string $resource = PlanejamentoReprodutivoResource::class;

    protected static ?string $title = 'Editar Planejamento Reprodutivo';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

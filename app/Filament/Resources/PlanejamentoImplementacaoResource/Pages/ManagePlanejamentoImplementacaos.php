<?php

namespace App\Filament\Resources\PlanejamentoImplementacaoResource\Pages;

use App\Filament\Resources\PlanejamentoImplementacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePlanejamentoImplementacaos extends ManageRecords
{
    protected static string $resource = PlanejamentoImplementacaoResource::class;

    protected static ?string $title = 'Planejamentos e Implementações';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Planejamento/Implementação'),
        ];
    }
}

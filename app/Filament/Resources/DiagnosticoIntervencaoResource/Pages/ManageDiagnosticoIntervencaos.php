<?php

namespace App\Filament\Resources\DiagnosticoIntervencaoResource\Pages;

use App\Filament\Resources\DiagnosticoIntervencaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDiagnosticoIntervencaos extends ManageRecords
{
    protected static string $resource = DiagnosticoIntervencaoResource::class;

    protected static ?string $title = 'Diagnósticos e Intervenções';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Diagnóstico/Intervenção'),
        ];
    }
}

<?php

namespace App\Filament\Resources\OrientacaoPacienteResource\Pages;

use App\Filament\Resources\OrientacaoPacienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOrientacaoPacientes extends ManageRecords
{
    protected static string $resource = OrientacaoPacienteResource::class;

    protected static ?string $title = 'Orientações aos Pacientes';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo')
            ->modalHeading('Criar Orientação'),
        ];
    }
}

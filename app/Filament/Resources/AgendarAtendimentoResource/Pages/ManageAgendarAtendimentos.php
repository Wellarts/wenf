<?php

namespace App\Filament\Resources\AgendarAtendimentoResource\Pages;

use App\Filament\Resources\AgendarAtendimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAgendarAtendimentos extends ManageRecords
{
    protected static string $resource = AgendarAtendimentoResource::class;

    protected static ?string $title = 'Atendimentos Agendados';



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Agendamento'),
        ];
    }
}

<?php

namespace App\Filament\Resources\AmamentacaoResource\Pages;

use App\Filament\Resources\AmamentacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmamentacaos extends ListRecords
{
    protected static string $resource = AmamentacaoResource::class;

    protected static ?string $title = 'Consultoria em Amamentação';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo'),
        ];
    }
}

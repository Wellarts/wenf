<?php

namespace App\Filament\Resources\PerinatalResource\Pages;

use App\Filament\Resources\PerinatalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerinatals extends ListRecords
{
    protected static string $resource = PerinatalResource::class;

    protected static ?string $title = 'Pré-Natal';

        protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo'),
        ];
    }
}

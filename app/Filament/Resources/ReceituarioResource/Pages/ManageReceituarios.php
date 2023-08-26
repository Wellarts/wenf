<?php

namespace App\Filament\Resources\ReceituarioResource\Pages;

use App\Filament\Resources\ReceituarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReceituarios extends ManageRecords
{
    protected static string $resource = ReceituarioResource::class;

    protected static ?string $title = 'Receituários';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo')
                ->modalHeading('Criar Receituário'),
        ];
    }
}

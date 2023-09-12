<?php

namespace App\Filament\Resources\AmamentacaoResource\Pages;

use App\Filament\Resources\AmamentacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAmamentacao extends CreateRecord
{
    protected static ?string $title = 'Cria Consultoria em Amamentação';

    protected static string $resource = AmamentacaoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

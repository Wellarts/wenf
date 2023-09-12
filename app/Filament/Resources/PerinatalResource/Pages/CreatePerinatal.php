<?php

namespace App\Filament\Resources\PerinatalResource\Pages;

use App\Filament\Resources\PerinatalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePerinatal extends CreateRecord
{
    protected static string $resource = PerinatalResource::class;

    protected static ?string $title = 'Pré-Natal';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

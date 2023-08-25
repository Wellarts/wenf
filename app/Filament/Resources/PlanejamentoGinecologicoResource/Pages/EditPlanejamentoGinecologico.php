<?php

namespace App\Filament\Resources\PlanejamentoGinecologicoResource\Pages;

use App\Filament\Resources\PlanejamentoGinecologicoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanejamentoGinecologico extends EditRecord
{
    protected static string $resource = PlanejamentoGinecologicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PlanejamentoGinecologicoResource\Pages;

use App\Filament\Resources\PlanejamentoGinecologicoResource;
use App\Models\Paciente;
use Carbon\Carbon;
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $paciente = Paciente::find($data['paciente_id']);
        $date =  Carbon::parse($paciente->data_nascimento);
        $idade = $date->diffInYears(Carbon::now());
        $data['idade'] = $idade;

        return $data;
    }
}

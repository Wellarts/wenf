<?php

namespace App\Filament\Resources\AmamentacaoResource\Pages;

use App\Filament\Resources\AmamentacaoResource;
use App\Models\Paciente;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmamentacao extends EditRecord
{
    protected static string $resource = AmamentacaoResource::class;

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

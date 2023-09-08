<?php

namespace App\Filament\Resources\PerinatalResource\Pages;

use App\Filament\Resources\PerinatalResource;
use App\Models\Paciente;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerinatal extends EditRecord
{
    protected static string $resource = PerinatalResource::class;

    protected static ?string $title = 'Pré-Natal';

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

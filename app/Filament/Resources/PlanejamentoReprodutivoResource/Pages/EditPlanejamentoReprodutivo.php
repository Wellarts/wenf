<?php

namespace App\Filament\Resources\PlanejamentoReprodutivoResource\Pages;

use App\Filament\Resources\PlanejamentoReprodutivoResource;
use App\Models\Paciente;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanejamentoReprodutivo extends EditRecord
{
    protected static string $resource = PlanejamentoReprodutivoResource::class;

    protected static ?string $title = 'Editar Planejamento Reprodutivo';

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

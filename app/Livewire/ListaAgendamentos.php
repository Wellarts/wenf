<?php

namespace App\Livewire;

use App\Models\AgendarAtendimento;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ListaAgendamentos extends BaseWidget
{

    protected static ?string $heading = 'Atendimentos Agendados';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AgendarAtendimento::query()->where('status', 0)->orderby('data_atendimento', 'asc'),
            )
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('data_atendimento')
                    ->label('Data do Atendimento')
                    ->alignCenter()
                    ->date()
                    ->badge()
                    ->color(static function ($state): string {
                        $hoje = Carbon::today();
                        $dataAgendamento = Carbon::parse($state);
                        $qtd_dias = $hoje->diffInDays($dataAgendamento, false);

                        if ($qtd_dias <= 3 && $qtd_dias >= 0) {
                            return 'danger';
                        }

                        if($qtd_dias < 0) {
                            return 'warning';
                        }

                        if($qtd_dias > 3) {
                            return 'success';
                        }

                    }),
                Tables\Columns\TextColumn::make('hora_atendimento')
                    ->label('Hora do Atendimento')
                    ->alignCenter(),

            ]);
    }
}

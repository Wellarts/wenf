<?php

namespace App\Livewire;

use App\Models\AgendarAtendimento;
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
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_atendimento')
                    ->label('Data do Atendimento')
                    ->alignCenter()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hora_atendimento')
                    ->label('Hora do Atendimento')
                    ->alignCenter()
                    ->searchable(),
            ]);
    }
}

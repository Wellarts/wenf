<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendarAtendimentoResource\Pages;
use App\Filament\Resources\AgendarAtendimentoResource\RelationManagers;
use App\Models\AgendarAtendimento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgendarAtendimentoResource extends Resource
{
    protected static ?string $model = AgendarAtendimento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data_atendimento')
                    ->label('Data do Atendimento')
                    ->required(),
                Forms\Components\TimePicker::make('hora_atendimento')
                    ->label('Hora do Atendimento')
                    ->required(),
                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status')
                    ->label('Atendimento Realizado')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\IconColumn::make('status')
                    ->label('Atendimento Realizado')
                    ->alignCenter()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAgendarAtendimentos::route('/'),
        ];
    }
}

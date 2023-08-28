<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiagnosticoIntervencaoResource\Pages;
use App\Filament\Resources\DiagnosticoIntervencaoResource\RelationManagers;
use App\Models\DiagnosticoIntervencao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiagnosticoIntervencaoResource extends Resource
{
    protected static ?string $model = DiagnosticoIntervencao::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Diagnósticos e Intervenções';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo')
                    ->label('Código')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descricao')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Radio::make('tipo')
                    ->options([
                        '1' => 'Ginecológico',
                        '2' => 'Reprodutivo',
                        '3' => 'Perinatal',
                        '4' => 'Amamentação'
                    ])
                    ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('tipo')
                     ->options([
                        '1' => 'Ginecológico',
                        '2' => 'Reprodutivo',
                        '3' => 'Perinatal',
                        '4' => 'Amamentação'
                    ])
                    ->disabled(),
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
            'index' => Pages\ManageDiagnosticoIntervencaos::route('/'),
        ];
    }
}

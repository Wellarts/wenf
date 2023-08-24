<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PacienteResource\Pages;
use App\Filament\Resources\PacienteResource\RelationManagers;
use App\Models\Estado;
use App\Models\Paciente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data_nascimento')
                    ->label('Data de Nascimento')
                    ->required(),
                Forms\Components\Textarea::make('endereco')
                    ->label('Endereço')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('estado_id')
                    ->searchable()
                    ->label('Estado')
                    ->required()
                    ->options(Estado::all()->pluck('nome', 'id')->toArray())
                    ->reactive(),
                Forms\Components\Select::make('cidade_id')
                    ->searchable()
                    ->label('Cidade')
                    ->required()
                    ->options(function (callable $get) {
                        $estado = Estado::find($get('estado_id'));
                        if(!$estado) {
                            return Estado::all()->pluck('nome', 'id');
                        }
                        return $estado->cidade->pluck('nome','id');
                    })
                    ->reactive(),
                Forms\Components\TextInput::make('profissão')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone')
                    ->tel()
                    ->required()
                    ->mask('(99)99999-9999')
                    ->maxLength(255),
                Forms\Components\Radio::make('cor')
                    ->required()
                    ->inline()
                    ->options([
                        '1' => 'Branca',
                        '2' => 'Preta',
                        '3' => 'Parda',
                        '4' => 'Amarela',
                        '5' => 'Indígena',
                        '6' => 'Não Declarar',
                    ])->columnSpanFull(),

                Forms\Components\Textarea::make('obs')
                    ->label('Observações')
                     ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_nascimento')
                    ->label('Data de Nascimento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('profissão')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->searchable(),
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
            'index' => Pages\ManagePacientes::route('/'),
        ];
    }
}

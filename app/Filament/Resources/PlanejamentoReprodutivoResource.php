<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanejamentoReprodutivoResource\Pages;
use App\Filament\Resources\PlanejamentoReprodutivoResource\RelationManagers;
use App\Models\Estado;
use App\Models\Paciente;
use App\Models\PlanejamentoReprodutivo;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanejamentoReprodutivoResource extends Resource
{
    protected static ?string $model = PlanejamentoReprodutivo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Planejamentos Reprodutivos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Paciente')
                    ->schema([
                        Forms\Components\Select::make('paciente_id')
                            ->searchable()
                            ->relationship(name: 'paciente', titleAttribute: 'nome')
                            //  ->options(Paciente::all()->pluck('nome', 'id'))
                            ->createOptionForm([
                                Grid::make()
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
                                                if (!$estado) {
                                                    return Estado::all()->pluck('nome', 'id');
                                                }
                                                return $estado->cidade->pluck('nome', 'id');
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
                                    ]),
                            ]),
                        Forms\Components\DatePicker::make('data_atendimento')
                            ->default(Carbon::now())
                            ->label('Data do Atendimento')
                            ->required(),
                        Forms\Components\TextInput::make('peso')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('altura')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('imc')
                            ->label('IMC')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('temp')
                            ->label('Temperatura')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pa')
                            ->label('PA')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('spo2')
                            ->label('SPO2')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('fc')
                            ->label('FC')
                            ->maxLength(255),
                    ]),
                Fieldset::make('Levantamento')
                    ->schema([
                        Forms\Components\TextInput::make('queixa_principal')
                            ->label('Queixa Principal')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('historia_doenca')
                            ->label('Histórico da Doença')
                            ->columnSpanFull(),
                    ]),
                Fieldset::make('Antecedentes Ginecológicos e Sexuais')
                    ->schema([
                        Forms\Components\TextInput::make('menarca')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('dum')
                            ->label('DUM'),
                        Forms\Components\TextInput::make('ciclo_mestrual')
                            ->label('Ciclo Mestrual')
                            ->maxLength(255),
                        Forms\Components\radio::make('smp')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->label('SPM'),
                        Forms\Components\TextInput::make('metodo_contraceptivo')
                            ->label('Método Contraceptivo')
                            ->maxLength(255),
                        Forms\Components\Radio::make('dispareunia')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ]),
                        Forms\Components\Radio::make('corrimento')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->live(),
                        Forms\Components\TextInput::make('corrimento_desc')
                            ->hidden(fn (Get $get): bool => $get('corrimento') === null || $get('corrimento') === '0')
                            ->label('Descrição do Corrimento'),
                    ]),
                Fieldset::make('Antecedentes Obstétricos')
                    ->schema([
                        Forms\Components\TextInput::make('gesta')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('parto')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('aborto')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('gravidez_ectopica')
                            ->label('Gravidez Ectópica')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('intercorrencias')
                            ->label('Intercorrências')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('primeiro_parto')
                            ->label('Primeiro Parto'),
                        Forms\Components\DatePicker::make('ultimo_parto')
                            ->label('Último Parto'),
                        Forms\Components\TextInput::make('aleitamento')
                            ->label('Aleitamento')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('medicacao_uso')
                            ->label('Medicamento em Uso')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tabagistmo')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('etilismo')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('drogas')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sintomas_urinario')
                            ->label('Sintomas Urinário')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sintomas_intestinais')
                            ->label('Sintomas Intestinais')
                            ->maxLength(255),

                    ]),

                Fieldset::make('Antecedentes Pessoais e Familiar')
                    ->schema([
                        Grid::make('4')
                            ->schema([
                                Forms\Components\radio::make('cardiovasculares')
                                    ->label('Cardiovasculares:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('endocrinas')
                                    ->label('Endrocrinas:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('alergias')
                                    ->label('Alergias:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('vacinacao')
                                    ->label('Vacinação:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('ist_s')
                                    ->label('IST,S:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('cirurgias_transfusao')
                                    ->label('Cirurgias/Transfusão:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('cancer')
                                    ->label('Cancer:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),
                                Forms\Components\radio::make('outros:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ]),

                            ]),

                    ]),
                Fieldset::make('Histório de Exames Ginecológicos')
                    ->schema([
                        Forms\Components\Checkbox::make('mamografia')
                            ->live(),
                        Forms\Components\DatePicker::make('data_mamografia')
                            ->hidden(fn (Get $get): bool => !$get('mamografia'))
                            ->label('Data da Mamografia'),
                        Forms\Components\Checkbox::make('preventivo')
                            ->live(),
                        Forms\Components\DatePicker::make('data_preventivo')
                            ->hidden(fn (Get $get): bool => !$get('preventivo'))
                            ->label('Data do Preventivo'),
                    ]),

                Fieldset::make('Diagnósticos e Avaliações')
                    ->schema([
                        Forms\Components\Textarea::make('diagnostico')
                            ->label('Diagnóstico de Enfermagem')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('planejamento')
                            ->label('Planejamento/Implementação')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('avaliacao')
                             ->label('Avaliação/Retorno')
                             ->columnSpanFull(),
                        ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->label('Paciente')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_atendimento')
                    ->label('Data do Atendimento')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('queixa_principal')
                   ->label('Queixa Principal'),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Novo'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanejamentoReprodutivos::route('/'),
            'create' => Pages\CreatePlanejamentoReprodutivo::route('/create'),
            'edit' => Pages\EditPlanejamentoReprodutivo::route('/{record}/edit'),
        ];
    }
}

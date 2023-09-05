<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanejamentoGinecologicoResource\Pages;
use App\Filament\Resources\PlanejamentoGinecologicoResource\RelationManagers;
use App\Models\DiagnosticoIntervencao;
use App\Models\Estado;
use App\Models\PlanejamentoGinecologico;
use App\Models\PlanejamentoImplementacao;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PlanejamentoGinecologicoResource extends Resource
{
    protected static ?string $model = PlanejamentoGinecologico::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Planejamentos Ginecológicos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Paciente')
                    ->schema([
                        Forms\Components\Select::make('paciente_id')
                            ->searchable()
                            ->relationship(name: 'paciente', titleAttribute: 'nome')
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
                        Forms\Components\Radio::make('gravidez_ectopica')
                            ->label('Gravidez Ectópica')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ]),

                        Forms\Components\Radio::make('intercorrencias')
                            ->label('Intercorrências')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->live(),
                        Forms\Components\TextInput::make('intercorrencias_desc')
                            ->hidden(fn (Get $get): bool => $get('intercorrencias') === null || $get('intercorrencias') === '0')
                            ->label('Descrição das Intercorrências'),
                        Forms\Components\DatePicker::make('primeiro_parto')
                            ->label('Primeiro Parto'),
                        Forms\Components\DatePicker::make('ultimo_parto')
                            ->label('Último Parto'),
                        Forms\Components\Radio::make('medicacao_uso')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->live()
                            ->label('Medicacao em Uso'),
                        Forms\Components\TextInput::make('medicacao_uso_desc')
                            ->hidden(fn (Get $get): bool => $get('medicacao_uso') === null || $get('medicacao_uso') === '0')
                            ->label('Descrição da Medicação em Uso'),
                        Forms\Components\Radio::make('aleitamento')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ]),
                        Forms\Components\Radio::make('tabagismo')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ]),
                        Forms\Components\Radio::make('etilismo')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ]),
                        Forms\Components\Radio::make('drogas')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ]),
                        Section::make('Outros Sintomas')
                            ->columns('2')
                            ->schema([
                                Forms\Components\Radio::make('sintomas_urinario')
                                    ->options([
                                        '1' => 'Sim',
                                        '0' => 'Não',
                                    ])
                                    ->live()
                                    ->label('Sintomas Urinários'),
                                Forms\Components\TextInput::make('sintomas_urinario_desc')
                                    ->hidden(fn (Get $get): bool => $get('sintomas_urinario') === null || $get('sintomas_urinario') === '0')
                                    ->label('Descrição dos Sintomas Urinário'),
                                Forms\Components\Radio::make('sintomas_intestinais')
                                    ->options([
                                        '1' => 'Sim',
                                        '0' => 'Não',
                                    ])
                                    ->live()
                                    ->label('Sintomas Intestinais'),
                                Forms\Components\TextInput::make('sintomas_intestinais_desc')
                                    ->hidden(fn (Get $get): bool => $get('sintomas_intestinais') === null || $get('sintomas_intestinais') === '0')
                                    ->label('Descrição dos Sintomas Intestinais'),

                            ]),


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
                                    ])
                                    ->live(),
                                Forms\Components\TextInput::make('cardiovasculares_desc')
                                    ->hidden(fn (Get $get): bool => $get('cardiovasculares') === null || $get('cardiovasculares') === '0')
                                    ->label('Descrição do Cardiovascular'),
                                Forms\Components\radio::make('endocrinas')
                                    ->label('Endrocrinas:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ])->live(),
                                Forms\Components\TextInput::make('endocrinas_desc')
                                    ->hidden(fn (Get $get): bool => $get('endocrinas') === null || $get('endocrinas') === '0')
                                    ->label('Descrição das Endocrinas'),
                                Forms\Components\radio::make('alergias')
                                    ->label('Alergias:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ])->live(),
                                Forms\Components\TextInput::make('alergias_desc')
                                    ->hidden(fn (Get $get): bool => $get('alergias') === null || $get('alergias') === '0')
                                    ->label('Descrição das Alergias'),
                                Forms\Components\radio::make('ist_s')
                                    ->label('IST,S:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ])->live(),
                                Forms\Components\TextInput::make('ist_s_desc')
                                    ->hidden(fn (Get $get): bool => $get('ist_s') === null || $get('ist_s') === '0')
                                    ->label('Descrição das IST,S'),
                                Forms\Components\radio::make('cirurgias_transfusao')
                                    ->label('Cirurgias/Transfusão:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ])->live(),
                                Forms\Components\TextInput::make('cirurgias_transfusao_desc')
                                    ->hidden(fn (Get $get): bool => $get('cirurgias_transfusao') === null || $get('cirurgias_transfusao') === '0')
                                    ->label('Descrição das Cirurgias e Transfusões'),
                                Forms\Components\radio::make('cancer')
                                    ->label('Cancer:')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ])->live(),
                                Forms\Components\TextInput::make('cancer_desc')
                                    ->hidden(fn (Get $get): bool => $get('cancer') === null || $get('cancer') === '0')
                                    ->label('Descrição do Cancer'),
                                Forms\Components\radio::make('outros')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Pessoal',
                                        '2' => 'Familiar',
                                    ])->live(),
                                Forms\Components\TextInput::make('outros_desc')
                                    ->hidden(fn (Get $get): bool => $get('outros') === null || $get('outros') === '0')
                                    ->label('Descrição dos Outros'),

                            ]),

                    ]),
                Fieldset::make('Vacinas')
                    ->schema([
                        Section::make('Antitetânica (dT)')
                            ->columns('5')
                            ->schema([
                                Forms\Components\radio::make('vacina_dt')
                                    ->label('')
                                    ->options([
                                        '0' => 'Sem informação de imunização',
                                        '1' => 'Imunizada há menos de 5 anos',
                                        '2' => 'Imunizada há mais de 5 anos',
                                    ])->live(),
                                Forms\Components\DatePicker::make('vacina_dt_data_1')
                                    ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                    ->label('1º Dose'),
                                Forms\Components\DatePicker::make('vacina_dt_data_2')
                                    ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                    ->label('2º Dose'),
                                Forms\Components\DatePicker::make('vacina_dt_data_3')
                                    ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                    ->label('3º Dose'),
                                Forms\Components\DatePicker::make('vacina_dt_reforco')
                                    ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                    ->label('Reforco'),
                            ]),
                        Section::make('Vacina HPV')
                            ->columns('3')
                            ->schema([
                                Forms\Components\radio::make('vacina_hpv')
                                    ->label('')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Sim',

                                    ])->live(),
                                Forms\Components\DatePicker::make('vacina_hpv_data_1')
                                    ->hidden(fn (Get $get): bool => $get('vacina_hpv') === null || $get('vacina_hpv') === '0')
                                    ->label('1º Dose'),
                                Forms\Components\DatePicker::make('vacina_hpv_data_2')
                                    ->hidden(fn (Get $get): bool => $get('vacina_hpv') === null || $get('vacina_hpv') === '0')
                                    ->label('2º Dose'),
                            ]),
                        Section::make('Vacina Hepatite B')
                            ->columns('4')
                            ->schema([
                                Forms\Components\radio::make('vacina_hepatite_b')
                                    ->label('')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Sim',

                                    ])->live(),
                                Forms\Components\DatePicker::make('vacina_hepatite_b_data_1')
                                    ->hidden(fn (Get $get): bool => $get('vacina_hepatite_b') === null || $get('vacina_hepatite_b') === '0')
                                    ->label('1º Dose'),
                                Forms\Components\DatePicker::make('vacina_hepatite_b_data_2')
                                    ->hidden(fn (Get $get): bool => $get('vacina_hepatite_b') === null || $get('vacina_hepatite_b') === '0')
                                    ->label('2º Dose'),
                                Forms\Components\DatePicker::make('vacina_hepatite_b_data_3')
                                    ->hidden(fn (Get $get): bool => $get('vacina_hepatite_b') === null || $get('vacina_hepatite_b') === '0')
                                    ->label('3º Dose'),
                            ]),





                    ]),
                Fieldset::make('Exames das Mamas')
                    ->schema([
                        Forms\Components\TextInput::make('insp_estatica')
                            ->label('Inspeção Estática'),
                        Forms\Components\TextInput::make('insp_dinamica')
                            ->label('Inspeção Dinâmica'),
                        Forms\Components\TextInput::make('palpacao')
                            ->label('Palpação'),
                        Section::make('Descarga Papilar')
                            ->schema([
                                Forms\Components\Radio::make('descarga_papilar')
                                    ->options([
                                        '1' => 'Sim',
                                        '0' => 'Não',
                                    ])
                                    ->label('')
                                    ->live(),
                                Forms\Components\TextInput::make('descarga_papilar_desc')
                                    ->hidden(fn (Get $get): bool => $get('descarga_papilar') === null || $get('descarga_papilar') === '0')
                                    ->label('Descrição da Descarga Papilar'),
                            ]),
                        FileUpload::make('anexo_1')
                            ->label('Anexo do Exame de Mamas')
                            ->image()
                            ->imageEditor()


                    ]),
                Fieldset::make('Avaliação de Especular')
                    ->schema([
                        Section::make('Vulva')
                            ->columns('2')
                            ->schema([
                                Forms\Components\Radio::make('vulva')
                                    ->options([
                                        '0' => 'Fisiológico',
                                        '1' => 'Patológico',
                                    ])
                                    ->label('')
                                    ->live(),
                                Forms\Components\TextInput::make('vulva_desc')
                                    ->hidden(fn (Get $get): bool => $get('vulva') === null || $get('vulva') === '0')
                                    ->label('Descrição da Vulva'),
                            ]),


                        Forms\Components\TextInput::make('vagina')
                            ->label('Vagina'),
                        Forms\Components\TextInput::make('colo')
                            ->label('Colo'),
                        Forms\Components\TextInput::make('muco')
                            ->label('Muco'),
                        FileUpload::make('anexo_2')
                            ->label('Anexo da Avaliação Especular')
                            ->image()
                            ->imageEditor()
                    ]),

                Fieldset::make('Diagnósticos e Avaliações')
                    ->schema([
                        Forms\Components\Select::make('diagnostico_intervencao_id')
                            ->multiple()
                            ->getSearchResultsUsing(fn (string $search): array => DiagnosticoIntervencao::where('descricao', 'like', "%{$search}%")->limit(50)->pluck('descricao', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => DiagnosticoIntervencao::whereIn('id', $values)->pluck('descricao', 'id')->toArray())
                            ->label('Diagnósticos de Enfermagem'),

                        Forms\Components\Select::make('planejamento_implementacao_id')
                            ->multiple()
                            ->getSearchResultsUsing(fn (string $search): array => PlanejamentoImplementacao::where('descricao', 'like', "%{$search}%")->limit(50)->pluck('descricao', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => PlanejamentoImplementacao::whereIn('id', $values)->pluck('descricao', 'id')->toArray())
                            ->label('Planejamentos/Implementações'),

                        Forms\Components\Textarea::make('planejamento_desc')
                            ->label('Descrição do planejamento')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('avaliacao')
                            ->label('Avaliação/Retorno')
                            ->columnSpanFull(),
                        FileUpload::make('anexo_exame')
                            ->multiple()
                            ->label('Exames')
                            ->downloadable(),
                        FileUpload::make('anexo_outros')
                            ->multiple()
                            ->label('Outros Anexos')
                            ->downloadable()
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
                    ->alignCenter()
                    ->date('d/m/Y')
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
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListPlanejamentoGinecologicos::route('/'),
            'create' => Pages\CreatePlanejamentoGinecologico::route('/create'),
            'edit' => Pages\EditPlanejamentoGinecologico::route('/{record}/edit'),
        ];
    }
}

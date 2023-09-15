<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerinatalResource\Pages;
use App\Models\DiagnosticoIntervencao;
use App\Models\Estado;
use App\Models\Exame;
use App\Models\Paciente;
use App\Models\Perinatal;
use App\Models\PlanejamentoImplementacao;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerinatalResource extends Resource
{
    protected static ?string $model = Perinatal::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Pré-Natal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Paciente')
                    ->schema([
                        Grid::make([
                            'default' => 2,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 4,
                            'xl' => 4,
                            '2xl' => 4,
                        ])
                            ->schema([


                                Forms\Components\Select::make('paciente_id')
                                    ->columnSpan('2')
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $paciente = Paciente::find($state);
                                        $date =  Carbon::parse($paciente->data_nascimento);
                                        $idade = $date->diffInYears(Carbon::now());
                                        $set('idade', $idade);
                                    })
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
                                Forms\Components\TextInput::make('idade')
                                    ->disabled(),
                                Forms\Components\DatePicker::make('data')
                                    ->default(Carbon::now())
                                    ->label('Data do Cadastro'),
                                Forms\Components\TextInput::make('peso')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('altura')
                                    ->placeholder('0,00')
                                    //->mask('9,99')
                                    ->numeric(),
                                Forms\Components\DatePicker::make('dum')
                                    ->label('DUM'),
                                Forms\Components\DatePicker::make('dpp')
                                    ->label('DPP'),
                                Forms\Components\DatePicker::make('dpp_eco')
                                    ->label('DPP eco'),
                            ])
                    ]),
                Fieldset::make('Gestações')
                    ->schema([
                        Grid::make('6')
                            ->schema([
                                Forms\Components\TextInput::make('gesta')
                                    ->numeric(),
                                Forms\Components\TextInput::make('abortos')
                                    ->numeric()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('parto')
                                    ->numeric(),
                                Forms\Components\TextInput::make('parto_vaginal')
                                    ->numeric()
                                    ->label('Parto Vaginal')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('cesarea')
                                    ->label('Cesárea')
                                    ->numeric()
                                    ->maxLength(255),
                                Forms\Components\Radio::make('gravidez_planejada')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Sim',

                                    ])
                                    ->label('Gravidez Planejada'),
                                Forms\Components\TextInput::make('nascido_vivo')
                                    ->numeric()
                                    ->label('Nascidos Vivos')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nascido_vivo_vivem')
                                    ->numeric()
                                    ->label('Vivem')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nascido_morto')
                                    ->numeric()
                                    ->label('Nascidos Mortos')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('morto_semana_1')
                                    ->numeric()
                                    ->label('Morreram na 1º Semana')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('morto_depois_semana_1')
                                    ->numeric()
                                    ->label('Morreram depois na 1º Semana')
                                    ->maxLength(255),
                                Forms\Components\Radio::make('final_gesta_anterior_1_ano')
                                    ->label('Final da gestação anterior há 1 ano')
                                    ->options([
                                        '0' => 'Não',
                                        '1' => 'Sim',
                                    ]),
                                Forms\Components\Toggle::make('abortos_3')
                                    ->inline(false)
                                    ->label('3 ou + abortos'),
                                Forms\Components\Toggle::make('bebe_2500')
                                    ->inline(false)
                                    ->label('Bebê < 2.500g'),

                                Forms\Components\Toggle::make('bebe_4500')
                                    ->inline(false)
                                    ->label('Bebê > 4.500g'),

                                Forms\Components\Toggle::make('pre_eclampsia')
                                    ->inline(false)
                                    ->label('Pré-eclâmpsia'),

                                Forms\Components\Toggle::make('gesta_ectopia')
                                    ->inline(false)
                                    ->label('Gestação Ectópica'),



                                Forms\Components\Toggle::make('cesarea_previa_2')
                                    ->inline(false)
                                    ->label('2 cesarea prévias'),

                                Fieldset::make('Vacinas')
                                    ->schema([
                                        Section::make('Vacina Antitetânica (dT)')
                                            ->columns('6')
                                            ->schema([
                                                Forms\Components\radio::make('vacina_dt')
                                                    ->label('')
                                                    ->options([
                                                        '0' => 'Não',
                                                        '1' => 'Sim',
                                                    ]),
                                                //->live(),
                                                Forms\Components\DatePicker::make('vacina_dt_data_1')
                                                    //  ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                                    ->label('1º Dose'),
                                                Forms\Components\DatePicker::make('vacina_dt_data_2')
                                                    //   ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                                    ->label('2º Dose'),
                                                Forms\Components\DatePicker::make('vacina_dt_data_3')
                                                    //  ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                                    ->label('3º Dose'),
                                                Forms\Components\DatePicker::make('vacina_dt_reforco')
                                                    //   ->hidden(fn (Get $get): bool => $get('vacina_dt') === null || $get('vacina_dt') === '0')
                                                    ->label('Reforco'),
                                                Forms\Components\DatePicker::make('vacina_dtpa')
                                                    ->label('dTpa'),
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
                                        Section::make('Vacina Influenza')
                                            ->columns('2')
                                            ->schema([
                                                Forms\Components\radio::make('vacina_influenza')
                                                    ->label('')
                                                    ->options([
                                                        '0' => 'Não',
                                                        '1' => 'Sim',

                                                    ])->live(),
                                                Forms\Components\DatePicker::make('vacina_influenza_data')
                                                    ->hidden(fn (Get $get): bool => $get('vacina_influenza') === null || $get('vacina_influenza') === '0')
                                                    ->label('Data'),
                                            ]),

                                    ]),
                                Fieldset::make('Exames')
                                    ->columns('2')
                                    ->schema([
                                        Repeater::make('exames')
                                            ->label('')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        Select::make('exame_id')
                                                            ->label('Exame')
                                                            ->options(Exame::all()->pluck('nome', 'id')),
                                                        DatePicker::make('data'),
                                                        TextInput::make('resultado'),
                                                    ])
                                            ])->columnSpanFull(),
                                    ]),

                                Fieldset::make('Ultrassonografias')
                                    ->columns('2')
                                    ->schema([
                                        Repeater::make('ultrassons')
                                            ->label('')
                                            ->schema([
                                                Grid::make(6)
                                                    ->schema([
                                                        DatePicker::make('data'),
                                                        TextInput::make('ig_usg')
                                                            ->label('IG USG'),
                                                        TextInput::make('peso_fetal')
                                                            ->label('Peso Fetal'),
                                                        TextInput::make('placeta')
                                                            ->label('Placeta'),
                                                        TextInput::make('liquido')
                                                            ->label('Líquido'),
                                                        TextInput::make('bcf')
                                                            ->label('BCF'),
                                                        TextInput::make('conclusao')
                                                            ->columnSpanFull()
                                                            ->label('Conclusão'),
                                                    ])
                                            ])->columnSpanFull(),
                                    ]),

                                Fieldset::make('Acompanhamentos')
                                    ->columns('2')
                                    ->schema([
                                        Repeater::make('acompanhamentos')
                                            ->label('')
                                            ->schema([
                                                Grid::make(5)
                                                    ->schema([
                                                        TextInput::make('consultas')
                                                            ->label('Consulta')
                                                            ->datalist([
                                                                '1º Consulta',
                                                                '2º Consulta',
                                                                '3º Consulta',
                                                                '4º Consulta',
                                                                '5º Consulta',
                                                                '6º Consulta',
                                                                '7º Consulta',
                                                                '8º Consulta',
                                                                '9º Consulta',
                                                                '10º Consulta',

                                                            ]),
                                                        DatePicker::make('data')
                                                            ->label('Data'),
                                                        TextInput::make('queixas')
                                                            // ->columnSpan('2')
                                                            ->label('Queixas'),
                                                        TextInput::make('ig_dum_usg')
                                                            ->label('IG DUM/USG'),
                                                        TextInput::make('peso_consulta')
                                                            ->label('Peso (kg)')
                                                            ->numeric()
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                                                $imc = (float)($state) / ((float)($get('../../altura') * $get('../../altura')));
                                                                $imc = round($imc);
                                                                $set('imc', $imc);
                                                            }),
                                                        TextInput::make('imc')
                                                            ->hint('Calculado quando alterar o peso')
                                                            ->readOnly()
                                                            ->label('IMC'),
                                                        TextInput::make('pressao')
                                                            ->label('Pressão Arterial (mmHG)'),
                                                        TextInput::make('altura_ulterina')
                                                            ->label('Altura Uterina (cm)'),
                                                        TextInput::make('apresentacao_fetal')
                                                            ->label('Apresentação Fetal'),
                                                        TextInput::make('bcf_mov_fetal')
                                                            ->label('BCF/Mov.Fetal'),
                                                        TextInput::make('edema')
                                                            ->label('Edema'),
                                                        Radio::make('sufato_ferroso')
                                                            ->label('Sufato Ferroso')
                                                            ->options([
                                                                '1' => 'Sim',
                                                                '2' => 'Não',
                                                            ]),
                                                        Radio::make('acido_folico')
                                                            ->label('Ácido Fólico')
                                                            ->options([
                                                                '1' => 'Sim',
                                                                '2' => 'Não',
                                                            ]),
                                                        Textarea::make('evolucao')
                                                            ->label('Evolução')
                                                            ->columnSpanFull(),

                                                    ]),

                                            ])->columnSpanFull(),

                                        Fieldset::make('Diagnósticos e Planejamentos')
                                            ->columns('3')
                                            ->schema([
                                                Repeater::make('diagnosticos')
                                                    ->label('')
                                                    ->schema([
                                                        Grid::make(3)
                                                            ->schema([
                                                                TextInput::make('consultas')
                                                                    ->label('Consulta')
                                                                    ->datalist([
                                                                        '1º Consulta',
                                                                        '2º Consulta',
                                                                        '3º Consulta',
                                                                        '4º Consulta',
                                                                        '5º Consulta',
                                                                        '6º Consulta',
                                                                        '7º Consulta',
                                                                        '8º Consulta',
                                                                        '9º Consulta',
                                                                        '10º Consulta',

                                                                    ]),
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
                                                            ]),
                                                    ])->columnSpanFull(),
                                                        ]),
                                            
                                        Forms\Components\Toggle::make('status')
                                            ->label('Finalizar Atendimento'),
                                    ])



                            ]),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('data')
                    ->date('d/m/Y')
                    ->label('Data do Atendimento'),
                Tables\Columns\TextColumn::make('peso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('altura')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Finalizado')
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
                Filter::make('finalizada')
                    ->label('Finalizadas')
                    ->query(fn (Builder $query): Builder => $query->where('status', true)),
                Filter::make('nao_finalizada')
                    ->label('Não Finalizadas')
                    ->query(fn (Builder $query): Builder => $query->where('status', false)),
                SelectFilter::make('paciente')->relationship('paciente', 'nome'),
                 Tables\Filters\Filter::make('data')
                    ->form([
                        Forms\Components\DatePicker::make('data_consulta_de')
                            ->label('Consulta de:'),
                        Forms\Components\DatePicker::make('data_consulta_ate')
                            ->label('Consulta até:'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['data_consulta_de'],
                                fn($query) => $query->whereDate('data', '>=', $data['data_consulta_de']))
                            ->when($data['data_consulta_ate'],
                                fn($query) => $query->whereDate('data', '<=', $data['data_consulta_ate']));
                    })
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerinatals::route('/'),
            'create' => Pages\CreatePerinatal::route('/create'),
            'edit' => Pages\EditPerinatal::route('/{record}/edit'),
        ];
    }
}

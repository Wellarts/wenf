<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AmamentacaoResource\Pages;
use App\Filament\Resources\AmamentacaoResource\RelationManagers;
use App\Models\Amamentacao;
use App\Models\DiagnosticoIntervencao;
use App\Models\Estado;
use App\Models\Paciente;
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
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AmamentacaoResource extends Resource
{
    protected static ?string $model = Amamentacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Consultoria em Amamentação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Amamentação na Gestação')
                    ->columns('4')
                    ->schema([
                        Forms\Components\Select::make('paciente_id')
                            ->columnSpan([
                                'xl' => 1,
                                '2xl' => 1,
                            ])
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
                                            ->required(false)
                                            ->maxLength(255),
                                        Forms\Components\DatePicker::make('data_nascimento')
                                            ->label('Data de Nascimento')
                                            ->required(false),
                                        Forms\Components\Textarea::make('endereco')
                                            ->label('Endereço')
                                            ->required(false)
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('estado_id')
                                            ->searchable()
                                            ->label('Estado')
                                            ->required(false)
                                            ->options(Estado::all()->pluck('nome', 'id')->toArray())
                                            ->reactive(),
                                        Forms\Components\Select::make('cidade_id')
                                            ->searchable()
                                            ->label('Cidade')
                                            ->required(false)
                                            ->options(function (callable $get) {
                                                $estado = Estado::find($get('estado_id'));
                                                if (!$estado) {
                                                    return Estado::all()->pluck('nome', 'id');
                                                }
                                                return $estado->cidade->pluck('nome', 'id');
                                            })
                                            ->reactive(),
                                        Forms\Components\TextInput::make('profissão')
                                            ->required(false)
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('telefone')
                                            ->tel()
                                            ->required(false)
                                            ->mask('(99)99999-9999')
                                            ->maxLength(255),
                                        Forms\Components\Radio::make('cor')
                                            ->required(false)
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
                            ->disabled()
                            ->label('Idade'),
                        Forms\Components\DatePicker::make('data_consulta_gestacao')
                            ->label('Data - Consulta Gestação')
                            ->required(false),
                        Forms\Components\DatePicker::make('dpp')
                            ->label('DPP'),
                        Forms\Components\Textarea::make('historico_amamentacao')
                            ->label('Histórico Amamentação')
                            ->columnSpan([
                                'xl' => 2,
                                '2xl' => 2,
                            ])
                            ->required(false),

                        Forms\Components\Textarea::make('principais_duvidas')
                            ->label('Principais Dúvidas')
                            ->columnSpan([
                                'xl' => 2,
                                '2xl' => 2,
                            ])
                            ->required(false)

                    ]),
                Fieldset::make('Amamentação Pós Parto')
                    ->columns('4')
                    ->schema([
                        Forms\Components\DatePicker::make('data_consulta_pos_parto')
                            ->label('Data - Consulta Pós Parto')
                            ->required(false),
                        Forms\Components\TimePicker::make('hora_inicio')
                            ->label('Hora do Início')
                            ->seconds(false)
                            ->required(false),

                        Forms\Components\TimePicker::make('hora_termino')
                            ->label('Hora do Término')
                            ->seconds(false)
                            ->required(false),

                    ]),
                Fieldset::make('Avaliação Materna')
                    ->columns('6')
                    ->schema([
                        Forms\Components\Radio::make('pre_natal')
                            ->label('Pré-Natal')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->required(false),
                        Forms\Components\Radio::make('tipo_parto')
                            ->label('Tipo de Parto')
                            ->options([
                                '1' => 'Normal',
                                '2' => 'Cesária',

                            ])
                            ->required(false),
                        Forms\Components\Radio::make('tipo_mamas')
                            ->label('Tipos de Mamas')
                            ->options([
                                '1' => 'Grande',
                                '2' => 'Média',
                                '3' => 'Pequena',
                            ])
                            ->required(false),
                        Forms\Components\Radio::make('tipo_mamilo')
                            ->label('Tipo de Mamilo')
                            ->options([
                                '1' => 'Protuso',
                                '2' => 'Plano',
                                '3' => 'Invertido',
                            ])
                            ->required(false),
                        Forms\Components\Radio::make('aparencias_mamas')
                            ->label('Aparência Mamas')
                            ->options([
                                '1' => 'Turgidas',
                                '2' => 'Flácidas',

                            ])
                            ->required(false),

                        Forms\Components\Radio::make('saida_leite')
                            ->label('Saída de Leite')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',

                            ])
                            ->required(false),
                        Forms\Components\Radio::make('historico_doenças')
                            ->label('Histórico de Doenças')
                            ->live()
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',

                            ])
                            ->required(false),
                        Forms\Components\TextInput::make('historico_doenças_desc')
                            ->columnSpan([
                                'xl' => 2,
                                '2xl' => 2,
                            ])
                            ->label('Descrição - Histórico de Doenças')
                            ->hidden(fn (Get $get): bool => $get('historico_doenças') === null || $get('historico_doenças') === '0')
                            ->required(false)
                            ->maxLength(255),
                        Forms\Components\Radio::make('cirurgias_mamarias')
                            ->label('Cirurgias Mamárias')
                            ->live()
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',

                            ])
                            ->required(false),
                        Forms\Components\TextInput::make('cirurgias_mamarias_desc')
                            ->columnSpan([
                                'xl' => 2,
                                '2xl' => 2,
                            ])
                            ->label('Descrição - Cirurgias Mamárias')
                            ->hidden(fn (Get $get): bool => $get('cirurgias_mamarias') === null || $get('cirurgias_mamarias') === '0')
                            ->required(false)
                            ->maxLength(255),

                        Forms\Components\Radio::make('hemorragia_pos_parto')
                            ->label('Hemorragia Pós-Parto')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->required(false),
                        Forms\Components\Radio::make('medicacao_uso')
                            ->label('Medicação em Uso')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->live(),
                        Forms\Components\TextInput::make('medicacao_uso_desc')
                            ->columnSpan([
                                'xl' => 2,
                                '2xl' => 2,
                            ])
                            ->hidden(fn (Get $get): bool => $get('medicacao_uso') === null || $get('medicacao_uso') === '0')
                            ->label('Descrição - Medicação em Uso'),
                        Forms\Components\Radio::make('rede_apoio')
                            ->label('Rede de Apoio')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                            ])
                            ->required(false),

                        Forms\Components\Textarea::make('obs')
                            ->label('Observações')
                            ->required(false)
                            ->columnSpanFull(),
                    ]),
                Fieldset::make('Alterações')
                    ->columns('7')
                    ->schema([
                        Forms\Components\CheckboxList::make('alteracoes_mamarias')
                            ->label('Alterações Mamárias')
                            ->columns([
                                'xl' => 7,
                                '2xl' => 7,
                            ])
                            ->columnSpan([
                                'xl' => 7,
                                '2xl' => 7,
                            ])
                            ->options([
                                '1' => 'Fissuras',
                                '2' => 'Nódulos',
                                '3' => 'Prurido',
                                '4' => 'Eritema',
                                '5' => 'Hematoma',
                            ])
                            ->required(false),
                        Forms\Components\TextInput::make('obs_mamarias')
                            ->label('Observações Mamárias')
                            ->required(false)
                            ->columnSpanFull(),
                        Forms\Components\CheckboxList::make('avaliacao_dor')
                            ->label('Avaliação da Dor:')

                            ->columns([
                                'xl' => 7,
                                '2xl' => 7,
                            ])
                            ->columnSpan([
                                'xl' => 7,
                                '2xl' => 7,
                            ])
                            ->options([
                                '1' => 'Ausência de Dor',
                                '2' => 'Dor em Fisgada',
                                '3' => 'Dor Intermitente',
                                '4' => 'Dor Contínua',
                                '5' => 'Dor no Início da Mamada',
                            ])
                            ->required(false),
                        Forms\Components\Radio::make('intesidade_dor')
                            ->label('Intesidade da Dor (Escala de 0 a 10):')
                            ->inline()
                            ->columnSpan([
                                'xl' => 7,
                                '2xl' => 7,
                            ])
                            ->options([
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '5' => '5',
                                '6' => '6',
                                '7' => '7',
                                '8' => '8',
                                '9' => '9',
                                '10' => '10',
                            ])
                            ->required(false),
                        FileUpload::make('anexo_mamas')
                            ->label('Anexo Mamas')
                            ->columnSpanFull()
                            ->downloadable(),

                    ]),
                Fieldset::make('Avaliação do Bebê')
                    ->columns('5')
                    ->schema([
                       
                        Forms\Components\TextInput::make('ig')
                            ->label('IG')
                            ->required(false)
                            ->maxLength(50),
                       
                        Forms\Components\TextInput::make('apgar_1_mim')
                            ->label('APGAR: 1º mim')
                            ->required(false)
                            ->maxLength(50),
                        Forms\Components\TextInput::make('apgar_5_mim')
                            ->label('APGAR: 2º mim')
                            ->required(false)
                            ->maxLength(50),

                        Forms\Components\TextInput::make('peso_nasc')
                            ->label('Peso do Nascimento')
                            ->required(false)
                            ->maxLength(50),
                        Forms\Components\TextInput::make('peso_atual')
                            ->label('Peso Atual')
                            ->required(false)
                            ->maxLength(50),
                        Forms\Components\Radio::make('sexo')
                            ->options([
                                '1' => 'Masculino',
                                '2' => 'Feminino',
                            ])
                            ->required(false),
                        Forms\Components\Radio::make('padrao_motor')
                            ->label('Padrão Motor')
                            ->options([
                                '1' => 'Flexão',
                                '2' => 'Hipotonia',
                            ])
                            ->required(false),

                        Forms\Components\Radio::make('conciencia')
                            ->label('Estado de Conciência')
                          //  ->inlineLabel(false)
                          /*  ->columnSpan([
                                'xl' => 3,
                                '2xl' => 3,
                            ])
                            ->inline() */
                            ->options([
                                '1' => 'Sono Profundo',
                                '2' => 'Sono Leve',
                                '3' => 'Sonolento',
                                '4' => 'Alerta',
                                '5' => 'Choro',

                            ])
                            ->required(false),
                        Forms\Components\Radio::make('refluxo')
                            ->label('Presença de Refluxo')
                            ->options([
                                '1' => 'Sim',
                                '0' => 'Não',
                           ])
                            ->live()
                            ->required(false),

                        Forms\Components\TextInput::make('refluxo_vezes')
                            ->label('Refluxo - Quantas Vezes')
                            ->hidden(fn (Get $get): bool => $get('refluxo') === null || $get('refluxo') === '0')
                            ->required(false)
                            ->maxLength(50),
                        Fieldset::make('Eliminações')
                            ->columns('5')
                            ->schema([

                                Forms\Components\Radio::make('diurese')
                                    ->label('Diurese')
                                    ->options([
                                        '1' => 'Presente',
                                        '0' => 'Ausente',
                                    ])
                                    ->live()
                                    ->required(false),

                                Forms\Components\TextInput::make('diurese_qtd_fraldas')
                                    ->label('Diurese - Qtd Fraldas')
                                    ->hidden(fn (Get $get): bool => $get('diurese') === null || $get('diurese') === '0')
                                    ->required(false)
                                    ->maxLength(50),
                                Forms\Components\Radio::make('evacuacoes')
                                    ->label('Evacuações')
                                    ->options([
                                        '1' => 'Presente',
                                        '0' => 'Ausente',
                                    ])
                                    ->live()
                                    ->required(false),
                                Forms\Components\TextInput::make('evacuacoes_color')
                                    ->label('Evacuações - Coloração')
                                    ->hidden(fn (Get $get): bool => $get('evacuacoes') === null || $get('evacuacoes') === '0')
                                    ->required(false)
                                    ->maxLength(50),
                                Forms\Components\Radio::make('reflexos')
                                    ->label('Reflexos')
                                    ->options([
                                        '1' => 'Presente',
                                        '0' => 'Ausente',
                                    ])
                                    ->live()
                                    ->required(false),
                                Forms\Components\TextInput::make('reflexos_desc')
                                    ->label('Descrição - Reflexos')
                                    ->hidden(fn (Get $get): bool => $get('reflexos') === null || $get('reflexos') === '0')
                                    ->required(false)
                                    ->maxLength(50),
                                
                                Forms\Components\Radio::make('uso_bicos')
                                    ->label('Uso de Bicos')
                                    ->live()
                                    ->options([
                                        '1' => 'Sim',
                                        '0' => 'Não',
                                    ])
                                    ->required(false),

                                Forms\Components\TextInput::make('uso_desc')
                                    ->label('Descrição - Bicos')
                                    ->hidden(fn (Get $get): bool => $get('uso_bicos') === null || $get('uso_bicos') === '0')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\Radio::make('formula_infaltil')
                                    ->label('Fórmula Infaltil')
                                    ->live()
                                    ->options([
                                        '1' => 'Sim',
                                        '0' => 'Não',
                                    ])
                                    ->required(false),
                                Forms\Components\TextInput::make('formula_infaltil_desc')
                                    ->label('Descrição - Fórmula Infantil')
                                    ->hidden(fn (Get $get): bool => $get('formula_infaltil') === null || $get('formula_infaltil') === '0')
                                    ->required(false)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('padrao_succao')
                                    ->columnSpan([
                                        'xl' => 2,
                                        '2xl' => 2,
                                    ])
                                    ->label('Padrão Sucção')
                                    ->required(false)
                                    ->maxLength(50),
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
                                Forms\Components\Toggle::make('status')
                                    ->label('Finalizar Atendimento'),



                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->label('Paciente')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_consulta_gestacao')
                    ->label('Consulta - Gestação')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_consulta_pos_parto')
                    ->label('Consulta - Pós-Parto')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListAmamentacaos::route('/'),
            'create' => Pages\CreateAmamentacao::route('/create'),
            'edit' => Pages\EditAmamentacao::route('/{record}/edit'),
        ];
    }
}

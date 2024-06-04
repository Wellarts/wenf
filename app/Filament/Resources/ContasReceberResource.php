<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContasReceberResource\Pages;
use App\Filament\Resources\ContasReceberResource\RelationManagers;
use App\Models\ContasReceber;
use App\Models\FluxoCaixa;
use App\Models\Paciente;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
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


class ContasReceberResource extends Resource
{
    protected static ?string $model = ContasReceber::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $title = 'Contas a Receber';

    protected static ?string $navigationLabel = 'Contas a Receber';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paciente_id')
                    ->label('Paciente')
                    ->options(Paciente::all()->pluck('nome', 'id')->toArray())
                    ->required(),
                Forms\Components\TextInput::make('valor_total')
                    ->numeric()
                    ->label('Valor Total')
                    ->required(),
                Forms\Components\TextInput::make('parcelas')
                    ->numeric()
                    ->hiddenOn('edit')
                    ->live(debounce:500)
                    ->afterStateUpdated(function (Get $get, callable $set) {
                        if($get('parcelas') != 1)
                           {
                            $set('valor_parcela', ((float)($get('valor_total') / $get('parcelas'))));
                            $set('status', 0);
                            $set('valor_recebido', 0);
                            $set('data_recebimento', null);
                            fn (Set $set) => $set('data_vencimento',  Carbon::now()->addDays(30)->format('Y-m-d'));
                           }
                        else
                            {

                                $set('valor_parcela', $get('valor_total'));
                                $set('status', 1);
                                $set('valor_recebido', $get('valor_total'));
                                fn (Set $set) => $set('data_vencimento',  Carbon::now()->format('Y-m-d'));
                                fn (Set $set) => $set('data_recebimento',  Carbon::now()->format('Y-m-d'));


                            }

                    })
                    ->required(),
                Forms\Components\Select::make('formaPgmto')
                    ->default('2')
                    ->label('Forma de Pagamento')
                    ->required()
                    ->options([
                        1 => 'Dinheiro',
                        2 => 'Pix',
                        3 => 'Cartão',
                    ]),
                Forms\Components\Hidden::make('ordem_parcela')
                    ->label('Parcela Nº')
                    ->default('1'),

                Forms\Components\DatePicker::make('data_vencimento')
                    ->displayFormat('d/m/Y')
                    ->default(Carbon::now())
                    ->label("Data do Vencimento"),
                Forms\Components\DatePicker::make('data_recebimento')
                    ->displayFormat('d/m/Y')
                    ->default(Carbon::now())
                    ->label("Data do Recebimento"),
                Forms\Components\Toggle::make('status')
                    ->default('true')
                    ->label('Recebido')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, callable $set) {
                                if($get('status') == 1)
                                    {
                                        $set('valor_recebido', $get('valor_parcela'));
                                        $set('data_recebimento',  Carbon::now()->format('Y-m-d'));

                                    }
                                else
                                    {

                                        $set('valor_recebido', 0);
                                        $set('data_recebimento', null);
                                    }
                                }
                    ),

                Forms\Components\TextInput::make('valor_parcela')
                      ->label('Valor Parcela ')
                      ->numeric()
                      ->required(),
                Forms\Components\TextInput::make('valor_recebido')
                        ->label('Valor Recebido')
                        ->numeric(),
                Forms\Components\Textarea::make('obs')
                    ->label('Observações'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('ordem_parcela')
                ->alignCenter()
                ->label('Parcela Nº'),
            Tables\Columns\TextColumn::make('data_vencimento')
                ->sortable()
                ->alignCenter()
                ->badge()
                ->color('danger')
                ->date(),
            Tables\Columns\TextColumn::make('valor_total')
                ->alignCenter()
                ->badge()
                ->color('success')
                 ->money('BRL'),
            Tables\Columns\SelectColumn::make('formaPgmto')
                ->Label('Forma de Pagamento')
                ->disabled()
                ->options([
                    1 => 'Dinheiro',
                    2 => 'Pix',
                    3 => 'Cartão',
                ]),



            Tables\Columns\TextColumn::make('valor_parcela')
                ->alignCenter()
                ->badge()
                ->color('danger')
                ->money('BRL'),
            Tables\Columns\IconColumn::make('status')
                ->label('Recebido')
                ->boolean(),
            Tables\Columns\TextColumn::make('valor_recebido')
                ->label('Valor Recebido')
                ->alignCenter()
                ->badge()
                ->color('warning')
                ->money('BRL'),
            Tables\Columns\TextColumn::make('data_recebimento')
                ->alignCenter()
                ->badge()
                ->color('warning')
                ->date(),
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
                Filter::make('Aberta')
                ->query(fn (Builder $query): Builder => $query->where('status', false)),
                 SelectFilter::make('paciente')->relationship('paciente', 'nome'),
                 Tables\Filters\Filter::make('data_vencimento')
                    ->form([
                        Forms\Components\DatePicker::make('vencimento_de')
                            ->label('Vencimento de:'),
                        Forms\Components\DatePicker::make('vencimento_ate')
                            ->label('Vencimento até:'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['vencimento_de'],
                                fn($query) => $query->whereDate('data_vencimento', '>=', $data['vencimento_de']))
                            ->when($data['vencimento_ate'],
                                fn($query) => $query->whereDate('data_vencimento', '<=', $data['vencimento_ate']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->after(function ($data, $record) {

                    if($record->status == true)
                    {

                        $addFluxoCaixa = [
                            'valor' => ($record->valor_parcela),
                            'tipo'  => 'CREDITO',
                            'obs'   => 'Recebimento de conta',
                        ];

                        FluxoCaixa::create($addFluxoCaixa);
                    }
                }),
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
            'index' => Pages\ManageContasRecebers::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FornecedorResource\Pages;
use App\Filament\Resources\FornecedorResource\RelationManagers;
use App\Models\Estado;
use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Fornecedores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cpf_cnpj')
                    ->mask(RawJs::make(<<<'JS'
                                            $input.startsWith('14') || $input.startsWith('18') ? '999.999.999-99' : '99.999.999/9999-99'
                                        JS))
                    ->label('CPF/CNPJ'),
                Forms\Components\Textarea::make('endereco')
                    ->label('Endereço'),
                Forms\Components\Select::make('estado_id')
                    ->label('Estado')
                    ->required()
                    ->options(Estado::all()->pluck('nome', 'id')->toArray())
                    ->reactive(),
                Forms\Components\Select::make('cidade_id')
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
                Forms\Components\TextInput::make('telefone')
                    ->minLength(11)
                    ->maxLength(11)
                    ->required()
                    ->mask('(99)99999-9999')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('endereco')
                    ->label('Endereço'),
                Tables\Columns\TextColumn::make('estado.nome')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('cidade.nome')
                    ->label('Cidade'),
                Tables\Columns\TextColumn::make('telefone')
                    ->formatStateUsing(fn (string $state) => vsprintf('(%d%d)%d%d%d%d%d-%d%d%d%d', str_split($state)))
                    ->label('Telefone'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
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
            'index' => Pages\ManageFornecedors::route('/'),
        ];
    }
}

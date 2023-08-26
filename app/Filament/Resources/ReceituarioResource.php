<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceituarioResource\Pages;
use App\Filament\Resources\ReceituarioResource\RelationManagers;
use App\Models\Receituario;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceituarioResource extends Resource
{
    protected static ?string $model = Receituario::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Receituários';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paciente_id')
                    ->searchable()
                    ->relationship(name: 'paciente', titleAttribute: 'nome'),
                Forms\Components\DatePicker::make('data_receituario')
                    ->default(Carbon::now())
                    ->label('Data do Atendimento')
                    ->required(),
                Forms\Components\RichEditor::make('descricao')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_receituario')
                    ->label('Data')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ManageReceituarios::route('/'),
        ];
    }
}

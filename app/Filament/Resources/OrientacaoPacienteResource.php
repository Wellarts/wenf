<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrientacaoPacienteResource\Pages;
use App\Filament\Resources\OrientacaoPacienteResource\RelationManagers;
use App\Http\Controllers\Orientacao;
use App\Models\OrientacaoPaciente;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrientacaoPacienteResource extends Resource
{
    protected static ?string $model = OrientacaoPaciente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Orientações para Pacientes';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('paciente_id')
                    ->searchable()
                    ->relationship(name: 'paciente', titleAttribute: 'nome'),
                Forms\Components\DatePicker::make('data_orientacao')
                    ->default(Carbon::now())
                    ->label('Data do Atendimento')
                    ->required(),
                MarkdownEditor::make('descricao')
                    ->label('Descrição')
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
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
                 Tables\Columns\TextColumn::make('data_orientacao')
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
                Tables\Actions\Action::make('Imprimir')
                ->url(fn (OrientacaoPaciente $record): string => route('imprimirOrientacao', $record))
                ->openUrlInNewTab(),
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
            'index' => Pages\ManageOrientacaoPacientes::route('/'),
        ];
    }
}

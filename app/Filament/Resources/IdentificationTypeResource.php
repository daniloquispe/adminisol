<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdentificationTypeResource\Pages;
use App\Filament\Resources\IdentificationTypeResource\RelationManagers;
use App\Models\IdentificationType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IdentificationTypeResource extends Resource
{
    protected static ?string $model = IdentificationType::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				Forms\Components\TextInput::make('code')
					->helperText('Check SUNAT official tables')
					->required()
					->unique(ignoreRecord: true)
					->length(1)
					->autocapitalize(),
				Forms\Components\TextInput::make('name')
					->required()
					->maxLength(25),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				Tables\Columns\TextColumn::make('code'),
				Tables\Columns\TextColumn::make('name')->weight(FontWeight::Bold),
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
            'index' => Pages\ListIdentificationTypes::route('/'),
            'create' => Pages\CreateIdentificationType::route('/create'),
            'edit' => Pages\EditIdentificationType::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceTypeResource\Pages;
use App\Filament\Resources\InvoiceTypeResource\RelationManagers;
use App\Models\InvoiceType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceTypeResource extends Resource
{
    protected static ?string $model = InvoiceType::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Code (SUNAT)
				Forms\Components\TextInput::make('code')
					->required()
					->unique(ignoreRecord: true)
					->length(2)
					->autocapitalize()
					->helperText('Check SUNAT official tables'),
				// Name
				Forms\Components\TextInput::make('name')
					->required()
					->maxLength(25),
				// Has tax?
				Forms\Components\Checkbox::make('has_tax')
					->default(true)
					->label('Has tax?'),
				// Enabled?
				Forms\Components\Toggle::make('is_active')
					->default(true)
					->label('Is active?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				// Code
				Tables\Columns\TextColumn::make('code')
					->searchable(),
				// Name
				Tables\Columns\TextColumn::make('name')
					->weight(FontWeight::Bold)
					->searchable(),
				// Tax?
				Tables\Columns\IconColumn::make('has_tax')
					->boolean()
					->label('Tax?'),
				// Enabled?
				Tables\Columns\IconColumn::make('is_active')
					->boolean()
					->label('Active?'),
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
            'index' => Pages\ListInvoiceTypes::route('/'),
            'create' => Pages\CreateInvoiceType::route('/create'),
            'edit' => Pages\EditInvoiceType::route('/{record}/edit'),
        ];
    }
}

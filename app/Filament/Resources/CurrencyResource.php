<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrencyResource\Pages;
use App\Filament\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				Forms\Components\Section::make()
					->columns(2)
					->schema([
						// Code (ISO 4217)
						Forms\Components\TextInput::make('code')
							->required()
							->unique(ignoreRecord: true)
							->length(3)
							->autocapitalize()
							->helperText(new HtmlString('You can use <a href="https://es.wikipedia.org/wiki/ISO_4217" target="_blank">ISO 4217 standard codes</a> here')),
						// Name
						Forms\Components\TextInput::make('name')
							->required()
							->maxLength(25),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
			// Order by code
			->modifyQueryUsing(fn(Builder $query) => $query->orderBy('code'))
            ->columns([
				// Code
				Tables\Columns\TextColumn::make('code')->searchable()->sortable(),
				// Name
				Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}

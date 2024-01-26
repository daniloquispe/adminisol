<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankResource\Pages;
use App\Filament\Resources\BankResource\RelationManagers;
use App\Models\Bank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Name
				Forms\Components\TextInput::make('name')
					->required()
					->unique(ignoreRecord: true),
				// SWIFT code
				Forms\Components\TextInput::make('swift')
					->label('SWIFT code')
					->unique(ignoreRecord: true),
				// Enabled?
				Forms\Components\Checkbox::make('is_enabled')
					->default(true)
					->label('Is active?')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
			// Order by name
			->modifyQueryUsing(fn(Builder $query) => $query->orderBy('name'))
            ->columns([
				// Name
				Tables\Columns\TextColumn::make('name')
					->sortable(),
				// SWIFT code
				Tables\Columns\TextColumn::make('swift')
					->sortable(),
				// Enabled?
				Tables\Columns\IconColumn::make('is_enabled')
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
            'index' => Pages\ListBanks::route('/'),
            'create' => Pages\CreateBank::route('/create'),
            'edit' => Pages\EditBank::route('/{record}/edit'),
        ];
    }
}

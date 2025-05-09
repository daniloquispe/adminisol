<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankAccountResource\Pages;
use App\Filament\Resources\BankAccountResource\RelationManagers;
use App\Models\BankAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Bank
				Forms\Components\Select::make('bank_id')
					->relationship('bank', 'name')
					->required(),
				// Currency
				Forms\Components\Select::make('currency_id')
					->relationship('currency', 'name')
					->required(),
				// Account number
				Forms\Components\TextInput::make('number')
					->label('Account number')
					->maxLength(20)
					->required()
					->unique(ignoreRecord: true),
				// CCI
				Forms\Components\TextInput::make('cci')
					->label('CCI')
					->length(25)
					->unique(ignoreRecord: true),
				// IBAN
				Forms\Components\TextInput::make('iban')
					->label('IBAN')
					->length(34)
					->unique(ignoreRecord: true),
				// Enabled?
				Forms\Components\Toggle::make('is_active')
					->default(true)
					->label('Is active?')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				// Bank name
				Tables\Columns\TextColumn::make('bank.name'),
				// Number
				Tables\Columns\TextColumn::make('number'),
				// Currency
				Tables\Columns\TextColumn::make('currency.code'),
				// Enabled?
				Tables\Columns\ToggleColumn::make('is_active')
					->label('Active?'),
            ])
            ->filters([
				// Filter by currency
				Tables\Filters\SelectFilter::make('currency')
					->relationship('currency', 'code')
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }
}

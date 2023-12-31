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
				Forms\Components\Select::make('bank_id')
					->relationship('bank', 'name')
					->required(),
				Forms\Components\Select::make('currency_id')
					->relationship('currency', 'name')
					->required(),
				Forms\Components\TextInput::make('number')
					->label('Account number')
					->maxLength(20)
					->required()
					->unique(),
				Forms\Components\TextInput::make('cci')
					->label('CCI')
					->length(25)
					->unique(),
				Forms\Components\TextInput::make('iban')
					->label('IBAN')
					->length(34)
					->unique(),
				Forms\Components\Toggle::make('is_active')
					->default(true)
					->label('Is active?')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				Tables\Columns\TextColumn::make('bank.name'),
				Tables\Columns\TextColumn::make('number'),
				Tables\Columns\TextColumn::make('currency.code'),
				Tables\Columns\IconColumn::make('is_active')
					->boolean()
					->label('Active?'),
            ])
            ->filters([
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

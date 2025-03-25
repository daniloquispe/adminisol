<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RenewalResource\Pages;
use App\Filament\Resources\RenewalResource\RelationManagers;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Renewal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RenewalResource extends Resource
{
    protected static ?string $model = Renewal::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Section: Basic info
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
						// Customer
						Forms\Components\Select::make('customer_id')
							->label('Customer')
							->relationship('customer', 'name')
							->searchable()
							->required(),
						// Due date
						Forms\Components\DatePicker::make('due_at')
							->required(),
					]),
				// Section: Key dates
				Forms\Components\Section::make('Key dates')
					->columns(3)
					->visibleOn('edit')
					->schema([
						Forms\Components\DatePicker::make('notification_sent_at'),
						Forms\Components\DatePicker::make('payment_verified_at'),
						Forms\Components\DatePicker::make('renewed_at'),
					]),
				// Section: Payment info
				Forms\Components\Section::make('Payment info')
					->columns()
					->visibleOn('edit')
					->schema([
						// Bank
						Forms\Components\Select::make('bank_id')
							->label('Bank')
							->options(Bank::all()->pluck('name', 'id')),
						// Bank account
						Forms\Components\Select::make('bank_account_id')
							->label('Bank account')
							->options(BankAccount::all()->pluck('number', 'id'))
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				// Due date
				Tables\Columns\TextColumn::make('due_at')
					->description(fn(Renewal $record): string => $record->due_at->diffForHumans())
					->date(),
				// Customer
				Tables\Columns\TextColumn::make('customer.name'),
				// Total amount
				Tables\Columns\TextColumn::make('amount')
					->money('PEN'),
				// Status
				Tables\Columns\TextColumn::make('status')
					->badge(),
            ])
            ->filters([
				// Filter by customer
				Tables\Filters\SelectFilter::make('customer_id')
					->label('Customer')
					->relationship('customer', 'name')
					->searchable(),
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
			RelationManagers\DomainsRelationManager::class,
			RelationManagers\HostingAccountsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRenewals::route('/'),
            'create' => Pages\CreateRenewal::route('/create'),
            'edit' => Pages\EditRenewal::route('/{record}/edit'),
        ];
    }
}

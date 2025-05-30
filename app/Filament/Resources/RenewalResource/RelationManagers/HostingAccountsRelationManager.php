<?php

namespace App\Filament\Resources\RenewalResource\RelationManagers;

use App\Models\HostingAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostingAccountsRelationManager extends RelationManager
{
    protected static string $relationship = 'hostingAccounts';

	protected static ?string $icon = 'heroicon-o-server';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
					->label('Domain'),
				Tables\Columns\TextColumn::make('plan.name'),
				Tables\Columns\TextColumn::make('amount')
					->label('Amount (year)')
					->description(fn(HostingAccount $record): string => 'List price: PEN ' . $record->plan->price_year)
					->money('PEN'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
				Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
				Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
					Tables\Actions\DissociateBulkAction::make(),
                ]),
            ]);
    }
}

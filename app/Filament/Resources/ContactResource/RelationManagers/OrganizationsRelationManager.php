<?php

namespace App\Filament\Resources\ContactResource\RelationManagers;

use App\Filament\Resources\OrganizationResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationsRelationManager extends RelationManager
{
    protected static string $relationship = 'organizations';

    public function form(Form $form): Form
    {
        /*return $form
            ->schema([
				// Name
                Forms\Components\TextInput::make('name')
                    ->required()
					->unique()
                    ->maxLength(255),
				// Legal name
				Forms\Components\TextInput::make('legal_name')
					->unique()
					->maxLength(255),
				// Enabled?
				Forms\Components\Toggle::make('is_enabled')
					->label('Enabled?'),
            ]);*/
		return OrganizationResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
			->description('List of organizations where this contact works')
            ->recordTitleAttribute('name')
            ->columns([
				Tables\Columns\TextColumn::make('title')
					->label('Job title'),
				Tables\Columns\TextColumn::make('name')
					->label('Organization'),
				Tables\Columns\TextColumn::make('email')
					->label('E-mail'),
				Tables\Columns\IconColumn::make('is_owner')
					->boolean()
					->label('Owner?'),
				Tables\Columns\IconColumn::make('is_billing')
					->boolean()
					->label('Billing?'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
				Tables\Actions\AttachAction::make()
					->form(function (Tables\Actions\AttachAction $action): array
					{
						return [
							// Organization
							$action->getRecordSelect(),
							// Job title
							Forms\Components\TextInput::make('title')
								->label('Job title'),
							// E-mail
							Forms\Components\TextInput::make('email')
								->label('Business e-mail')
								->helperText('This e-mail can receive automated notifications (i.e. hosting or domain due dates)')
								->email(),
							// Owner?
							Forms\Components\Toggle::make('is_owner')
								->label('Is owner contact?'),
							// Billing contact
							Forms\Components\Toggle::make('is_billing')
								->label('Is billing contact?'),
						];
					}),
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
				Tables\Actions\DetachAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DetachBulkAction::make(),
//                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

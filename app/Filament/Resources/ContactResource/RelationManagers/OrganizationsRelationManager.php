<?php

namespace App\Filament\Resources\ContactResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OrganizationsRelationManager extends RelationManager
{
    protected static string $relationship = 'organizations';

	private static function pivotFormSchema(): array
	{
		return [
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
	}

    public function form(Form $form): Form
    {
        return $form->schema(self::pivotFormSchema());
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
					->form(fn(Tables\Actions\AttachAction $action) => array_merge([$action->getRecordSelect()], self::pivotFormSchema())),
            ])
            ->actions([
				Tables\Actions\EditAction::make(),
				Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
					Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}

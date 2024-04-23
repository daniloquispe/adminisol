<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Form $form): Form
    {
		return ContactResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
			->description('List of contacts working on this organization')
			->recordTitle(fn(Contact $contact) => $contact->last_and_first_name)
            ->columns([
				// Avatar
				Tables\Columns\ImageColumn::make('avatar_filename')
					->label('Avatar')
					->circular()
					->defaultImageUrl(fn(Contact $contact) => $contact->default_avatar_filename)
					->extraImgAttributes(fn(Contact $contact) => ['alt' => "{$contact->first_name}'s avatar"]),
				// Full name and job title
                Tables\Columns\TextColumn::make('last_and_first_name')
					->label('Full name')
					->description(fn(Contact $contact) => $contact->pivot->title)
					->weight(FontWeight::Bold)
					->sortable()
					->searchable(),
				// E-mail
				Tables\Columns\TextColumn::make('email')
					->label('E-mail')
					->sortable()
					->searchable(),
				// Owner contact?
				Tables\Columns\IconColumn::make('is_owner')
					->boolean()
					->label('Owner?'),
				// Billing contact?
				Tables\Columns\IconColumn::make('is_billing')
					->boolean()
					->label('Billing?'),
            ])
            ->filters([
				// Filter by status
				Tables\Filters\SelectFilter::make('status')
					->options(ContactResource::statuses()),
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

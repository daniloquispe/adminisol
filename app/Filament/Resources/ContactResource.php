<?php

namespace App\Filament\Resources;

use App\Enums\ContactStatus;
use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

	public static function statuses(): array
	{
		return collect(ContactStatus::cases())->pluck('name', 'value')->toArray();
	}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Basic info
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
						// Last name
						Forms\Components\TextInput::make('last_name')
							->required(),
						// First name
						Forms\Components\TextInput::make('first_name')
							->required(),
						// Status
						Forms\Components\Select::make('status')
							->options(self::statuses())
							->required(),
						// Notes
						Forms\Components\Textarea::make('notes')
							->autosize(),
					]),
				// Personal info
				Forms\Components\Section::make('Personal info')
					->columns(3)
					->schema([
						// Nickname
						Forms\Components\TextInput::make('nickname'),
						// Birthdate
						Forms\Components\DatePicker::make('birthdate'),
						// Avatar
						Forms\Components\FileUpload::make('avatar_filename')
							->label('Avatar')
							->image()
							->avatar()
							->imageEditor()
							->directory('avatars'),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
			->modifyQueryUsing(fn(Builder $query) => $query->orderBy('last_name')->orderBy('first_name'))
            ->columns([
				// Avatar
				Tables\Columns\ImageColumn::make('avatar_filename')
					->label('Avatar')
					->circular()
					->extraImgAttributes(fn(Contact $contact) => ['alt' => "{$contact->first_name}'s avatar"]),
				// Full name (last and first name)
				Tables\Columns\TextColumn::make('last_and_first_name')
					->label('Full name')
					->description(fn(Contact $contact) => $contact->nickname)
					->weight(FontWeight::Bold)
					->searchable(['last_name', 'first_name', 'nickname']),
				// Birthdate
				Tables\Columns\TextColumn::make('birthdate')
					->date()
					->searchable(),
				// Status
				Tables\Columns\TextColumn::make('status')
					->badge()
					->color(fn($state): string => match ($state)
					{
						ContactStatus::Active => 'success',
						ContactStatus::Inactive => 'warning',
						default => 'gray',
					})
					->formatStateUsing(fn($state) => $state->name),
            ])
            ->filters([
				// Filter by organization
				Tables\Filters\SelectFilter::make('organization_id')
					->label('Organization')
					->relationship('organizations', 'name')
					->searchable()
					->preload(),
				// Filter by status
				Tables\Filters\SelectFilter::make('status')
					->options(self::statuses()),
            ])
            ->actions([
				Tables\Actions\ViewAction::make(),
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
			RelationManagers\OrganizationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
			'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}

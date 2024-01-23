<?php

namespace App\Filament\Resources;

use App\Enums\DomainStatus;
use App\Filament\Resources\DomainResource\Pages;
use App\Filament\Resources\DomainResource\RelationManagers;
use App\Models\Domain;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

	private static function statuses(): array
	{
		return collect(DomainStatus::cases())->pluck('name', 'value')->toArray();
	}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// External?
				Forms\Components\Toggle::make('is_external')
					->label('Is an external domain?')
					->helperText('External domain are managed by 3rd-party domain vendors, not by us'),
				// Basic info
				Forms\Components\Section::make('Basic info')
					->columns(2)
					->schema([
						// Domain name
						Forms\Components\TextInput::make('name')
							->label('Domain name')
							->required(),
						// Client
						Forms\Components\Select::make('client_id')
							->relationship('client', 'name')
							->required(),
						// Status
						Forms\Components\Select::make('status')
							->options(self::statuses())
							->required(),
						// Notes
						Forms\Components\Textarea::make('Notes')
							->autosize(),
					]),
				// Key dates
				Forms\Components\Section::make('Key dates')
					->columns(3)
					->schema([
						// Registration date
						Forms\Components\DatePicker::make('registered_at')
							->maxDate(now()),
						// Expiration date
						Forms\Components\DatePicker::make('expiring_at')
							->maxDate(now()),
						// Cancellation/termination date
						Forms\Components\DatePicker::make('cancelled_at')
							->maxDate(now()),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
			// Order by name
			->modifyQueryUsing(fn(Builder $query) => $query->orderBy('name'))
            ->columns([
				// Domain name
				Tables\Columns\TextColumn::make('name')
					->label('Domain')
					->weight(FontWeight::Bold)
					->searchable(),
				// Client
				Tables\Columns\TextColumn::make('client.name')
					->searchable(),
				// Status
				Tables\Columns\TextColumn::make('status')
					->badge()
					->color(fn($state): string => match ($state)
					{
						DomainStatus::Active => 'success',
						DomainStatus::Expired => 'warning',
						DomainStatus::Cancelled => 'danger',
						default => 'gray'
					})
					->formatStateUsing(fn($state) => $state->name),
            ])
            ->filters([
				// Filter by client
				Tables\Filters\SelectFilter::make('client_id')
					->label('Client')
					->relationship('client', 'name'),
				// Filter by status
				Tables\Filters\SelectFilter::make('status')
					->options(self::statuses())
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
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}

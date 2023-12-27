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
				Forms\Components\Section::make('Basic info')
					->columns(2)
					->schema([
						Forms\Components\TextInput::make('name')
							->label('Domain name')
							->required(),
						Forms\Components\Select::make('client_id')
							->relationship('client', 'name')
							->required(),
						Forms\Components\Select::make('status')
							->options(self::statuses())
							->required(),
						Forms\Components\Textarea::make('Notes')
							->autosize(),
					]),
				Forms\Components\Section::make('Key dates')
					->columns(3)
					->schema([
						Forms\Components\DatePicker::make('registered_at')
							->maxDate(now()),
						Forms\Components\DatePicker::make('expiring_at')
							->maxDate(now()),
						Forms\Components\DatePicker::make('cancelled_at')
							->maxDate(now()),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				Tables\Columns\TextColumn::make('name')
					->label('Domain')
					->weight(FontWeight::Bold)
					->searchable(),
				Tables\Columns\TextColumn::make('client.name')
					->searchable(),
				Tables\Columns\TextColumn::make('status')
					->badge()
					->color(fn($state): string => match ($state)
					{
						DomainStatus::Active => 'success',
						DomainStatus::Expired => 'danger',
						default => 'gray'
					})
					->formatStateUsing(fn($state) => $state->name),
            ])
            ->filters([
				Tables\Filters\SelectFilter::make('client_id')
					->label('Client')
					->relationship('client', 'name'),
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

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Enabled?
				Forms\Components\Toggle::make('is_enabled')
					->default(true),
				// Basic info
				Forms\Components\Section::make('Basic info')
					->columns(2)
					->schema([
						// Name
						Forms\Components\TextInput::make('name')
							->required(),
						// Legal name
						Forms\Components\TextInput::make('legal_name'),
						// Invoice type
						Forms\Components\Select::make('invoice_type_id')
							->relationship('invoiceType', 'name')
							->searchable()
							->preload(),
						// Notes
						Forms\Components\Textarea::make('notes')
							->autosize(),
					]),
				// Key dates
				Forms\Components\Section::make('Key dates')
					->description('identify this organization as a client, vendor or prospecting assigning a start date')
					->columns(3)
					->schema([
						// Prospecting
						Forms\Components\DatePicker::make('prospecting_at')
							->maxDate(now()),
						// As client
						Forms\Components\DatePicker::make('as_client_at')
							->maxDate(now()),
						// As vendor
						Forms\Components\DatePicker::make('as_vendor_at')
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
				// Name
				Tables\Columns\TextColumn::make('name')
					->description(fn(Organization $organization) => $organization->legal_name)
					->weight(FontWeight::Bold)
					->searchable(),
				// As-client date
				Tables\Columns\TextColumn::make('as_client_at')
					->label('Client since')
					->date(),
				// As-vendor date
				Tables\Columns\TextColumn::make('as_vendor_at')
					->label('Vendor since')
					->date(),
				// Prospecting date
				Tables\Columns\TextColumn::make('prospecting_at')
					->label('Prospecting since')
					->date(),
				// Active?
				Tables\Columns\IconColumn::make('is_enabled')
					->boolean()
					->label('Active?'),
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostingPlanResource\Pages;
use App\Filament\Resources\HostingPlanResource\RelationManagers;
use App\Models\HostingPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostingPlanResource extends Resource
{
    protected static ?string $model = HostingPlan::class;

	protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				Forms\Components\Toggle::make('is_active')
					->label('Is active?')
					->default(true),
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
						Forms\Components\TextInput::make('name')
							->label('Plan name')
							->maxLength(25)
							->required(),
						Forms\Components\Select::make('type_id')
							->relationship('type', 'name')
							->label('Plan type')
							->required(),
					]),
				Forms\Components\Section::make('Technical info')
					->columns()
					->schema([
						Forms\Components\Fieldset::make('Capacity')
							->schema([
								Forms\Components\TextInput::make('capacity')
									->label('Value')
									->numeric()
									->required()
									->default(0),
								Forms\Components\Select::make('capacity_unit')
									->label('Unit')
									->options(['GB', 'MB'])
									->required(),
							]),
						Forms\Components\Fieldset::make('Transfer speed')
							->schema([
								Forms\Components\TextInput::make('transfer')
									->label('Value')
									->numeric()
									->required()
									->default(0),
								Forms\Components\Select::make('transfer_unit')
									->label('Unit')
									->options(['Mbps'])
									->required(),
							]),
					]),
				Forms\Components\Section::make('Price')
					->columns(2)
					->schema([
						Forms\Components\TextInput::make('price_year')
							->label('Per year')
							->required()
							->numeric()
							->default(0)
							->prefix('PEN'),
						Forms\Components\TextInput::make('price_month')
							->label('Per month')
							->required()
							->numeric()
							->default(0)
							->prefix('PEN'),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				Tables\Columns\TextColumn::make('name')
					->weight(FontWeight::Bold),
				Tables\Columns\TextColumn::make('type.name'),
				Tables\Columns\TextColumn::make('price_year')
					->label('Price (year)')
					->money('PEN'),
				Tables\Columns\TextColumn::make('price_month')
					->label('Price (month)')
					->money('PEN'),
				Tables\Columns\TextColumn::make('accounts_count')
					->label('Accounts')
					->counts('accounts'),
            ])
            ->filters([
				Tables\Filters\SelectFilter::make('type_id')
					->relationship('type', 'name')
					->label('Plan type'),
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
            'index' => Pages\ListHostingPlans::route('/'),
            'create' => Pages\CreateHostingPlan::route('/create'),
            'edit' => Pages\EditHostingPlan::route('/{record}/edit'),
        ];
    }
}

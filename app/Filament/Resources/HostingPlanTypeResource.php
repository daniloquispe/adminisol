<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HostingPlanTypeResource\Pages;
use App\Filament\Resources\HostingPlanTypeResource\RelationManagers;
use App\Models\HostingPlanType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HostingPlanTypeResource extends Resource
{
    protected static ?string $model = HostingPlanType::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

	protected static ?string $navigationGroup = 'Maintenance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				// Order number
				Forms\Components\TextInput::make('order')
					->numeric(),
				// Name
				Forms\Components\TextInput::make('name')
					->required(),
				// Description
				Forms\Components\TextInput::make('description')
					->required(),
				// Base color
				Forms\Components\ColorPicker::make('color')
					->label('Base color')
					->helperText('HTML hex format (#rrggbb)'),
				// Enabled?
				Forms\Components\Checkbox::make('is_active')
					->default(true)
					->label('Is active?')
					->helperText('If not active, hosting plans of this type will be unavailable')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				// Order number
				Tables\Columns\TextColumn::make('order')
					->sortable(),
				// Name
				Tables\Columns\TextColumn::make('name')
					->weight(FontWeight::Bold)
					->sortable(),
				// Base color
				Tables\Columns\ColorColumn::make('color')
					->label('Base color'),
				// Enabled?
				Tables\Columns\IconColumn::make('is_active')
					->boolean()
					->label('Active?'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListHostingPlanTypes::route('/'),
            'create' => Pages\CreateHostingPlanType::route('/create'),
            'edit' => Pages\EditHostingPlanType::route('/{record}/edit'),
        ];
    }
}

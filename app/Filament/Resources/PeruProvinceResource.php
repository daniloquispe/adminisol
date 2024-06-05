<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeruProvinceResource\Pages;
use App\Filament\Resources\PeruProvinceResource\RelationManagers;
use App\Models\PeruDepartment;
use App\Models\PeruProvince;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeruProvinceResource extends Resource
{
    protected static ?string $model = PeruProvince::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

	protected static ?string $navigationGroup = 'Ubigeo';

	protected static ?string $modelLabel = 'Peru province';

	protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				Forms\Components\Section::make('Basic info')
					->columns(3)
					->schema([
						Forms\Components\Select::make('department_id')
							->label('Department')
							->relationship('department', 'name')
							->searchable()
							->preload()
							->required(),
						Forms\Components\TextInput::make('id')
							->label('ID')
							->required()
							->length(2),
						Forms\Components\TextInput::make('name')
							->required(),
					]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
			->modifyQueryUsing(fn(Builder $query) => $query->with('department')->withCount('districts'))
            ->columns([
				Tables\Columns\TextColumn::make('id')
					->label('ID')
					->searchable(),
				Tables\Columns\TextColumn::make('department.name')
					->label('Department')
					->searchable(),
				Tables\Columns\TextColumn::make('name')
					->searchable()
					->weight(FontWeight::Bold),
				Tables\Columns\TextColumn::make('districts_count')
					->label('Districts')
            ])
            ->filters([
				Tables\Filters\SelectFilter::make('department')
					->relationship('department', 'name')
					->searchable()
					->preload(),
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
            'index' => Pages\ListPeruProvinces::route('/'),
            'create' => Pages\CreatePeruProvince::route('/create'),
            'edit' => Pages\EditPeruProvince::route('/{record}/edit'),
        ];
    }
}

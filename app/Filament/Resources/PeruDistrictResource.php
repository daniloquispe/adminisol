<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeruDistrictResource\Pages;
use App\Filament\Resources\PeruDistrictResource\RelationManagers;
use App\Models\PeruDistrict;
use App\Models\PeruProvince;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeruDistrictResource extends Resource
{
    protected static ?string $model = PeruDistrict::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

	protected static ?string $navigationGroup = 'Ubigeo';

	protected static ?string $modelLabel = 'Peru district';

	protected static ?int $navigationSort = 3;

	private static function provinces(string|null $departmentId): array
	{
		if (!$departmentId)
			return [];

		return PeruProvince::query()
			->select(['id', 'name'])
			->where('department_id', $departmentId)
			->pluck('name', 'id')
			->toArray();
	}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
						Forms\Components\Select::make('department_id')
							->label('Department')
							->relationship('department', 'name')
							->searchable()
							->preload()
							->required()
							->live(),
						Forms\Components\Select::make('province_id')
							->label('Province')
							->options(fn(Forms\Get $get) => self::provinces($get('department_id')))
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
			->modifyQueryUsing(fn(Builder $query) => $query->with(['province', 'department']))
            ->columns([
				Tables\Columns\TextColumn::make('id')
					->label('ID')
					->searchable(),
				Tables\Columns\TextColumn::make('department.name')
					->label('Department')
					->searchable(),
				Tables\Columns\TextColumn::make('province.name')
					->label('Province')
					->searchable(),
				Tables\Columns\TextColumn::make('name')
					->searchable()
					->weight(FontWeight::Bold),
            ])
            ->filters([
				Tables\Filters\SelectFilter::make('department')
					->relationship('department', 'name'),
				Tables\Filters\SelectFilter::make('province')
					->relationship('province', 'name'),
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
            'index' => Pages\ListPeruDistricts::route('/'),
            'create' => Pages\CreatePeruDistrict::route('/create'),
            'edit' => Pages\EditPeruDistrict::route('/{record}/edit'),
        ];
    }
}

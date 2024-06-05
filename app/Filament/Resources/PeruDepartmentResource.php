<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeruDepartmentResource\Pages;
use App\Filament\Resources\PeruDepartmentResource\RelationManagers;
use App\Models\PeruDepartment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeruDepartmentResource extends Resource
{
    protected static ?string $model = PeruDepartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

	protected static ?string $navigationGroup = 'Ubigeo';

	protected static ?string $modelLabel = 'Peru department';

	protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
				Forms\Components\Section::make('Basic info')
					->columns()
					->schema([
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
			->modifyQueryUsing(fn(Builder $query) => $query->withCount('provinces'))
            ->columns([
				Tables\Columns\TextColumn::make('id')
					->label('ID')
					->searchable(),
				Tables\Columns\TextColumn::make('name')
					->searchable()
					->weight(FontWeight::Bold),
				Tables\Columns\TextColumn::make('provinces_count')
					->label('Provinces')
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
            'index' => Pages\ListPeruDepartments::route('/'),
            'create' => Pages\CreatePeruDepartment::route('/create'),
            'edit' => Pages\EditPeruDepartment::route('/{record}/edit'),
        ];
    }
}

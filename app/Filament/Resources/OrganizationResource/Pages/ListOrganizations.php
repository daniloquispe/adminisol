<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrganizations extends ListRecords
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

	public function getTabs(): array
	{
		return [
			'all' => Tab::make('All'),
			'clients' => Tab::make('Clients')
				->modifyQueryUsing(fn(Builder $query) => $query->clients()),
			'vendors' => Tab::make('Vendors')
				->modifyQueryUsing(fn(Builder $query) => $query->vendors()),
			'prospects' => Tab::make('Prospects')
				->modifyQueryUsing(fn(Builder $query) => $query->prospects()),
		];
	}
}

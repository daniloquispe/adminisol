<?php

namespace App\Filament\Resources\HostingPlanTypeResource\Pages;

use App\Filament\Resources\HostingPlanTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHostingPlanTypes extends ListRecords
{
    protected static string $resource = HostingPlanTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

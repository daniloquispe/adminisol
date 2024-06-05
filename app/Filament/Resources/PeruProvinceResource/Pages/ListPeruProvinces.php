<?php

namespace App\Filament\Resources\PeruProvinceResource\Pages;

use App\Filament\Resources\PeruProvinceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeruProvinces extends ListRecords
{
    protected static string $resource = PeruProvinceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

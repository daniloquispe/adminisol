<?php

namespace App\Filament\Resources\PeruDepartmentResource\Pages;

use App\Filament\Resources\PeruDepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeruDepartments extends ListRecords
{
    protected static string $resource = PeruDepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\IdentificationTypeResource\Pages;

use App\Filament\Resources\IdentificationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdentificationTypes extends ListRecords
{
    protected static string $resource = IdentificationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PeruDistrictResource\Pages;

use App\Filament\Resources\PeruDistrictResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeruDistrict extends EditRecord
{
    protected static string $resource = PeruDistrictResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

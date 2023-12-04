<?php

namespace App\Filament\Resources\IdentificationTypeResource\Pages;

use App\Filament\Resources\IdentificationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdentificationType extends EditRecord
{
    protected static string $resource = IdentificationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

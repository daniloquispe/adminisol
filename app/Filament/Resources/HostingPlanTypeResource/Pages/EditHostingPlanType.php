<?php

namespace App\Filament\Resources\HostingPlanTypeResource\Pages;

use App\Filament\Resources\HostingPlanTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHostingPlanType extends EditRecord
{
    protected static string $resource = HostingPlanTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

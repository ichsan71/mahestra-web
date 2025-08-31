<?php

namespace App\Filament\Admin\Resources\Subsidiaries\Pages;

use App\Filament\Admin\Resources\Subsidiaries\SubsidiaryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSubsidiary extends ViewRecord
{
    protected static string $resource = SubsidiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

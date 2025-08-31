<?php

namespace App\Filament\Admin\Resources\Subsidiaries\Pages;

use App\Filament\Admin\Resources\Subsidiaries\SubsidiaryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSubsidiary extends EditRecord
{
    protected static string $resource = SubsidiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

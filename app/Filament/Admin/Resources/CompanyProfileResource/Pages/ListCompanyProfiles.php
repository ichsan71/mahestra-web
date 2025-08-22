<?php

namespace App\Filament\Admin\Resources\CompanyProfileResource\Pages;

use App\Filament\Admin\Resources\CompanyProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanyProfiles extends ListRecords
{
    protected static string $resource = CompanyProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

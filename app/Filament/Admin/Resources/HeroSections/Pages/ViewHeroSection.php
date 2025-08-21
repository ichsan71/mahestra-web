<?php

namespace App\Filament\Admin\Resources\HeroSections\Pages;

use App\Filament\Admin\Resources\HeroSections\HeroSectionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHeroSection extends ViewRecord
{
    protected static string $resource = HeroSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

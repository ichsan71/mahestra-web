<?php

namespace App\Filament\Admin\Resources\Testimonials\Pages;

use App\Filament\Admin\Resources\Testimonials\TestimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTestimonial extends EditRecord
{
    protected static string $resource = TestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

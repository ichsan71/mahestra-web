<?php

namespace App\Filament\Admin\Resources\Testimonials\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pelanggan')
                    ->placeholder('Contoh: Budi Santoso'),
                Textarea::make('message')
                    ->required()
                    ->maxLength(1000)
                    ->label('Testimoni')
                    ->placeholder('Tulis testimoni pelanggan di sini...')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Tampilkan di Website')
                    ->default(true)
                    ->helperText('Matikan untuk menyembunyikan testimoni dari website'),
            ]);
    }
}

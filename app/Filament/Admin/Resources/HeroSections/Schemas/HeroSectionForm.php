<?php

namespace App\Filament\Admin\Resources\HeroSections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HeroSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Hero')
                    ->placeholder('Contoh: Mahestra Printing — Cetak Cepat'),
                Textarea::make('subtitle')
                    ->required()
                    ->maxLength(500)
                    ->label('Subtitle')
                    ->placeholder('Deskripsi singkat tentang layanan Anda')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->label('Gambar Hero')
                    ->disk('public')
                    ->directory('hero-images')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Tampilkan di Website')
                    ->default(true)
                    ->helperText('Matikan untuk menyembunyikan hero section dari website'),
            ]);
    }
}

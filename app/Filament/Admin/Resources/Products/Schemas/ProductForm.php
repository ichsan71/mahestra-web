<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Produk')
                    ->placeholder('Contoh: Cetak Brosur A4'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp ')
                    ->label('Harga')
                    ->placeholder('50000'),
                FileUpload::make('image')
                    ->image()
                    ->label('Gambar Produk')
                    ->disk('public')
                    ->directory('product-images')
                    ->imageEditor()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Deskripsi detail produk...')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Tampilkan di Website')
                    ->default(true)
                    ->helperText('Matikan untuk menyembunyikan produk dari website'),
            ]);
    }
}

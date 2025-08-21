<?php

namespace App\Filament\Admin\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('whatsapp')
                    ->label('Nomor WhatsApp')
                    ->placeholder('+6281234567890')
                    ->tel()
                    ->helperText('Format: +628xxxxxxxxxx'),
                TextInput::make('instagram')
                    ->label('Username Instagram')
                    ->placeholder('@mahestraprint')
                    ->helperText('Dengan atau tanpa @ di depan'),
                Textarea::make('address')
                    ->label('Alamat')
                    ->placeholder('Jl. Contoh No. 123, Jakarta')
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Admin\Resources\Contacts;

use App\Filament\Admin\Resources\Contacts\Pages\CreateContact;
use App\Filament\Admin\Resources\Contacts\Pages\EditContact;
use App\Filament\Admin\Resources\Contacts\Pages\ListContacts;
use App\Filament\Admin\Resources\Contacts\Pages\ViewContact;
use App\Filament\Admin\Resources\Contacts\Schemas\ContactForm;
use App\Filament\Admin\Resources\Contacts\Schemas\ContactInfolist;
use App\Filament\Admin\Resources\Contacts\Tables\ContactsTable;
use App\Models\Contact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-phone';

    protected static ?string $recordTitleAttribute = 'whatsapp';

    protected static ?string $navigationLabel = 'Kontak';

    protected static ?string $modelLabel = 'Kontak';

    protected static ?string $pluralModelLabel = 'Kontak';

    public static function form(Schema $schema): Schema
    {
        return ContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'view' => ViewContact::route('/{record}'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }
}

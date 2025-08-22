<?php

namespace App\Filament\Admin\Resources;

use App\Models\CompanyProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table as TablesTable;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\CompanyProfileResource\Pages\ListCompanyProfiles;
use App\Filament\Admin\Resources\CompanyProfileResource\Pages\CreateCompanyProfile;
use App\Filament\Admin\Resources\CompanyProfileResource\Pages\EditCompanyProfile;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Company Profile';
    protected static ?string $pluralLabel = 'Company Profile';
    protected static ?string $slug = 'company-profile';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->label('Judul'),
                TextInput::make('subtitle')->label('Subjudul'),
                Textarea::make('description')->label('Deskripsi')->columnSpanFull(),
                Textarea::make('main_services')->label('Layanan Utama')->helperText('Pisahkan layanan dengan baris baru')->rows(4),
                FileUpload::make('image')
                    ->image()
                    ->directory('company-profile')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->disk('public')
                    ->label('Gambar'),
            ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('subtitle'),
                Tables\Columns\TextColumn::make('main_services')->limit(50),
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompanyProfiles::route('/'),
            'create' => CreateCompanyProfile::route('/create'),
            'edit' => EditCompanyProfile::route('/{record}/edit'),
        ];
    }
}
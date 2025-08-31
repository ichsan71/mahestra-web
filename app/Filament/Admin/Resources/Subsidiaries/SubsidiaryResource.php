<?php

namespace App\Filament\Admin\Resources\Subsidiaries;

use App\Models\Subsidiary;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table as TablesTable;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Admin\Resources\Subsidiaries\Pages\ListSubsidiaries;
use App\Filament\Admin\Resources\Subsidiaries\Pages\CreateSubsidiary;
use App\Filament\Admin\Resources\Subsidiaries\Pages\EditSubsidiary;
use App\Filament\Admin\Resources\Subsidiaries\Pages\ViewSubsidiary;

class SubsidiaryResource extends Resource
{
    protected static ?string $model = Subsidiary::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Anak Perusahaan';
    protected static ?string $pluralLabel = 'Anak Perusahaan';
    protected static ?string $slug = 'subsidiaries';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->placeholder('Masukkan judul subsidiary')
                    ->maxLength(255),

                TextInput::make('name')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->placeholder('Masukkan nama perusahaan')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi perusahaan')
                    ->rows(4)
                    ->maxLength(1000),

                FileUpload::make('image')
                    ->label('Gambar')
                    ->image()
                    ->directory('subsidiaries')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->disk('public')
                    ->maxSize(2048)
                    ->helperText('Upload gambar perusahaan (max 2MB, format: JPG, PNG, WebP)'),

                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(true)
                    ->helperText('Aktifkan untuk menampilkan di halaman utama'),
            ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl('/images/logo.svg')
                    ->size(40),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Tidak ada judul'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubsidiaries::route('/'),
            'create' => CreateSubsidiary::route('/create'),
            'view' => ViewSubsidiary::route('/{record}'),
            'edit' => EditSubsidiary::route('/{record}/edit'),
        ];
    }
}

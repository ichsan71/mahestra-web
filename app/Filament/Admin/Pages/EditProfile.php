<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Edit Profile';

    protected static ?string $title = 'Edit Profile';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 98;

    public string $name = '';
    public string $email = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
    ];

    protected $validationAttributes = [
        'name' => 'Nama',
        'email' => 'Email',
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        // Update validation rules to exclude current user email
        $this->rules['email'] = 'required|email|unique:users,email,' . $user->id;
    }

    public function updateProfile(): void
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Tampilkan notifikasi sukses
        Notification::make()
            ->title('Profile berhasil diperbarui!')
            ->body('Informasi profile Anda telah berhasil disimpan.')
            ->success()
            ->send();
    }

    public function getView(): string
    {
        return 'filament.admin.pages.edit-profile';
    }
}

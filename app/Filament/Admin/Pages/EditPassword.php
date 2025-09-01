<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditPassword extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationLabel = 'Ubah Password';

    protected static ?string $title = 'Ubah Password';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 99;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $validationAttributes = [
        'current_password' => 'Password saat ini',
        'password' => 'Password baru',
        'password_confirmation' => 'Konfirmasi password',
    ];

    public function updatePassword(): void
    {
        $this->validate();

        // Validasi password saat ini
        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Password saat ini tidak benar.');
            return;
        }

        // Update password
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->password)
        ]);

        // Reset form
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        // Tampilkan notifikasi sukses
        Notification::make()
            ->title('Password berhasil diubah!')
            ->body('Password Anda telah berhasil diperbarui.')
            ->success()
            ->send();
    }

    public function getView(): string
    {
        return 'filament.admin.pages.edit-password';
    }
}

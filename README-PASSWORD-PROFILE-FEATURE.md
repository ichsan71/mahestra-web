# Fitur Edit Password & Profile - Mahestra Web

## Deskripsi

Fitur ini menambahkan kemampuan untuk mengelola akun pengguna di dalam admin panel Filament, mencakup:

1. **Edit Password** - Mengubah password pengguna dengan validasi password lama
2. **Edit Profile** - Mengubah informasi nama dan email pengguna

## Fitur Yang Ditambahkan

### 1. Halaman Edit Password

-   **Lokasi**: `/admin-safe/edit-password`
-   **Navigasi**: Pengaturan > Ubah Password
-   **Fitur**:
    -   Validasi password lama
    -   Password baru minimal 8 karakter
    -   Konfirmasi password
    -   Notifikasi sukses
    -   Update langsung ke database

### 2. Halaman Edit Profile

-   **Lokasi**: `/admin-safe/edit-profile`
-   **Navigasi**: Pengaturan > Edit Profile
-   **Fitur**:
    -   Edit nama pengguna
    -   Edit alamat email (dengan validasi unique)
    -   Notifikasi sukses
    -   Update langsung ke database

## File Yang Dibuat/Dimodifikasi

### Backend (PHP)

1. `app/Filament/Admin/Pages/EditPassword.php` - Controller untuk halaman edit password
2. `app/Filament/Admin/Pages/EditProfile.php` - Controller untuk halaman edit profile

### Frontend (Blade Templates)

1. `resources/views/filament/admin/pages/edit-password.blade.php` - View untuk edit password
2. `resources/views/filament/admin/pages/edit-profile.blade.php` - View untuk edit profile

## Cara Penggunaan

### Login Admin

1. Akses: `http://localhost:8000/admin-safe/login`
2. Email: `operator@mahestra.com`
3. Password: `OperatoR!`

### Edit Password

1. Login ke admin panel
2. Klik menu "Pengaturan" > "Ubah Password"
3. Masukkan password saat ini
4. Masukkan password baru (min 8 karakter)
5. Konfirmasi password baru
6. Klik "Ubah Password"

### Edit Profile

1. Login ke admin panel
2. Klik menu "Pengaturan" > "Edit Profile"
3. Edit nama dan/atau email
4. Klik "Simpan Profile"

## Keamanan

### Password

-   Validasi password lama sebelum mengubah
-   Hash menggunakan bcrypt
-   Notifikasi sukses hanya setelah berhasil update database

### Profile

-   Validasi email unique (kecuali untuk email saat ini)
-   Validasi input required
-   Update langsung ke database dengan Eloquent

## Styling

-   Menggunakan tema Filament yang konsisten
-   Support dark mode
-   Responsive design
-   Consistent dengan komponen lain

## Testing

### Test Edit Password

1. Login dengan password lama
2. Coba ubah password dengan password lama yang salah (harus error)
3. Coba ubah password dengan password baru yang tidak match konfirmasi (harus error)
4. Ubah password dengan data yang benar (harus berhasil)
5. Logout dan login kembali dengan password baru

### Test Edit Profile

1. Ubah nama pengguna (harus berhasil)
2. Coba ubah email ke email yang sudah ada (harus error jika ada user lain)
3. Ubah email ke email baru yang valid (harus berhasil)

## Integrasi

-   Halaman terintegrasi penuh dengan navigation Filament
-   Menggunakan notification system Filament
-   Menggunakan styling system Filament
-   Menggunakan Livewire untuk interaktivitas

## Maintenance

-   File terorganisir sesuai struktur Filament
-   Code mengikuti Laravel best practices
-   Validation rules dapat disesuaikan di controller
-   Styling dapat dimodifikasi di view files

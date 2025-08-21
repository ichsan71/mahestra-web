# Mahestra Printing - Filament Admin Setup

## ✅ Instalasi Selesai!

Filament admin panel telah berhasil diinstall dan dikonfigurasi untuk mengelola konten website Mahestra Printing.

## 🚀 Akses Admin Panel

-   **URL Admin**: http://127.0.0.1:8000/admin
-   **Email**: admin@mahestra.com
-   **Password**: [password yang Anda masukkan saat setup]

## 📊 Fitur Admin Panel

### 1. Hero Section

-   Mengelola judul dan subtitle utama website
-   Upload gambar hero
-   Toggle publish/unpublish

### 2. Produk

-   Tambah/edit/hapus produk
-   Upload gambar produk
-   Set harga dan deskripsi
-   Toggle publish/unpublish

### 3. Kontak

-   Kelola nomor WhatsApp
-   Username Instagram
-   Alamat perusahaan

### 4. Testimoni

-   Tambah testimoni pelanggan
-   Kelola nama dan pesan
-   Toggle publish/unpublish

## 🔧 Penggunaan

1. **Login ke Admin**: Buka http://127.0.0.1:8000/admin
2. **Kelola Konten**: Gunakan menu navigasi kiri untuk mengelola:

    - Hero Section (bagian utama website)
    - Produk (daftar produk/layanan)
    - Kontak (informasi kontak)
    - Testimoni (testimoni pelanggan)

3. **Upload Gambar**:

    - Hero: Upload gambar untuk bagian hero (rasio 16:9 recommended)
    - Produk: Upload gambar produk (square format recommended)

4. **Preview**: Setelah mengubah konten, buka http://127.0.0.1:8000 untuk melihat perubahan

## 📁 Struktur File Penting

```
app/
├── Filament/Admin/Resources/        # Admin resources
├── Http/Controllers/HomeController.php
├── Models/                          # Model untuk Hero, Product, Contact, Testimonial
└── Providers/Filament/AdminPanelProvider.php

database/
├── migrations/                      # Database schema
└── seeders/DatabaseSeeder.php      # Sample data

resources/
├── css/
│   ├── app.css                     # Main CSS
│   └── theme-bright.css            # Theme colors
└── views/landing.blade.php         # Main landing page

storage/
└── app/public/                     # Uploaded files storage
```

## 🎨 Kustomisasi

### Theme Colors (resources/css/theme-bright.css)

-   Primary: #F53003 (merah)
-   Secondary: #25D366 (hijau WhatsApp)
-   Background: #FFFDF5 (krem)

### Layout (resources/views/landing.blade.php)

-   Hero section dengan gambar dan CTA
-   Grid produk responsif
-   Kontak dengan WhatsApp dan Instagram
-   Testimoni pelanggan

## 🛠️ Commands Berguna

```bash
# Refresh cache setelah perubahan
php artisan config:clear
php artisan view:clear

# Seed ulang data sample
php artisan db:seed

# Membuat user admin baru
php artisan make:filament-user

# Start development server
php artisan serve
```

## 📝 Next Steps

1. **Customize Content**: Login ke admin dan ubah konten sesuai kebutuhan
2. **Upload Images**: Tambahkan gambar hero dan produk
3. **Update Contact**: Masukkan nomor WhatsApp dan Instagram yang benar
4. **Add Products**: Tambahkan produk/layanan Anda
5. **Collect Testimonials**: Tambahkan testimoni pelanggan

## 🚀 Production Deployment

Untuk deployment ke production:

1. Set environment variables yang benar
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Run `php artisan view:cache`
5. Set file permissions untuk storage directory
6. Configure web server (Apache/Nginx)

---

✨ **Website Anda siap digunakan!** ✨

Akses admin panel di http://127.0.0.1:8000/admin untuk mulai mengelola konten.

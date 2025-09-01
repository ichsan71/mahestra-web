# Solusi Error 403 pada Route /login - UPDATE

## Masalah

Error 403 (Forbidden) terjadi saat mengakses route `/login` setelah deploy ke hosting.

## File yang Telah Diperbaiki:

### 1. ✅ `routes/web.php`

Route authentication sudah diperbaiki menggunakan controller yang proper

### 2. ✅ `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

Controller authentication sudah diupdate untuk redirect ke `/admin-safe`

### 3. ✅ `bootstrap/app.php`

Middleware debugging untuk error 403 sudah ditambahkan

### 4. ✅ `app/Http/Middleware/Debug403Middleware.php`

Middleware untuk logging request ke `/login` dan response 403

### 5. ✅ `index.php`

File redirect untuk hosting yang tidak menggunakan public folder sebagai document root

### 6. ✅ `deploy.sh`

Script deployment otomatis dengan permission dan cache setup

### 7. ✅ `.env.production`

Template environment untuk production dengan konfigurasi yang benar

## Langkah Deploy ke Hosting:

### Option A: Manual

1. Upload semua file ke hosting
2. Copy `.env.production` ke `.env` dan update dengan detail hosting Anda
3. Set permission:
    ```bash
    chmod -R 755 storage/
    chmod -R 755 bootstrap/cache/
    ```
4. Jalankan command:
    ```bash
    php artisan storage:link
    php artisan config:cache
    php artisan route:cache
    ```

### Option B: Otomatis

```bash
chmod +x deploy.sh
./deploy.sh
```

## Troubleshooting Error 403:

### 1. Check Document Root

-   Pastikan hosting menggunakan folder `public` sebagai document root
-   Atau gunakan file `index.php` di root yang sudah dibuat

### 2. Check Environment

Update `.env` dengan:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
SESSION_DOMAIN=yourdomain.com
```

### 3. Check Log

File debugging akan mencatat ke: `storage/logs/laravel.log`

### 4. Check PHP Extensions

Pastikan hosting memiliki:

-   PHP >= 8.1
-   Extensions: openssl, pdo, mbstring, tokenizer, xml, ctype, json, bcmath

### 5. Check ModSecurity

Hubungi hosting provider untuk:

-   Disable ModSecurity untuk domain Anda
-   Whitelist aplikasi Laravel

## Test Setelah Deploy:

1. Akses domain Anda
2. Klik link login atau akses `/login`
3. Check apakah form login muncul
4. Test login dengan credentials yang valid
5. Check log di `storage/logs/laravel.log` jika masih error

## Jika Masih Error 403:

1. Check dengan hosting provider tentang server configuration
2. Minta check error log server (Apache/Nginx)
3. Pastikan database connection working
4. Check IP restrictions atau firewall settings

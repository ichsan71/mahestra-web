# Solusi Error 403 pada Route /login

## Masalah

Error 403 (Forbidden) terjadi saat mengakses route `/login` setelah deploy ke hosting.

## Penyebab Kemungkinan dan Solusi

### 1. Konfigurasi Environment (.env)

**Masalah**: Konfigurasi environment tidak sesuai dengan hosting
**Solusi**:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Session settings untuk production
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=yourdomain.com
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
```

### 2. File .htaccess

**Masalah**: Konfigurasi Apache tidak tepat
**Solusi**: Pastikan file `.htaccess` di folder `public` memiliki konfigurasi yang benar (sudah benar).

### 3. Permission File dan Folder

**Masalah**: Permission tidak tepat di hosting
**Solusi**:

```bash
# Set permission yang benar
chmod 755 storage/
chmod 755 bootstrap/cache/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### 4. Storage Link

**Masalah**: Symbolic link storage tidak terbuat
**Solusi**:

```bash
php artisan storage:link
```

### 5. Cache dan Config

**Masalah**: Cache lama atau konfigurasi tidak ter-update
**Solusi**:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
```

### 6. Middleware dan CSRF

**Masalah**: CSRF token atau middleware blocking request
**Solusi**: Pastikan meta tag CSRF ada di layout guest:

```html
<meta name="csrf-token" content="{{ csrf_token() }}" />
```

### 7. Composer Dependencies

**Masalah**: Dependencies tidak ter-install dengan benar
**Solusi**:

```bash
composer install --optimize-autoloader --no-dev
```

### 8. File Index.php di Root

**Masalah**: Hosting tidak menggunakan public folder sebagai document root
**Solusi**: Buat file `index.php` di root dengan redirect:

```php
<?php
header('Location: public/index.php');
exit();
?>
```

### 9. ModSecurity atau WAF

**Masalah**: Web Application Firewall memblokir request
**Solusi**: Hubungi provider hosting untuk whitelist aplikasi Laravel

### 10. PHP Version

**Masalah**: Versi PHP tidak kompatibel
**Solusi**: Pastikan hosting menggunakan PHP 8.1 atau lebih tinggi

## Langkah Debugging

1. Check log error: `tail -f storage/logs/laravel.log`
2. Check Apache/Nginx error log
3. Test dengan browser incognito
4. Check network tab di developer tools
5. Coba akses route lain untuk memastikan hanya `/login` yang bermasalah

## Implementasi untuk Production

Buat script deploy otomatis:

```bash
#!/bin/bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

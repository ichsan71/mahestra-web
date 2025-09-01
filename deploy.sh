#!/bin/bash

# Script untuk deploy Laravel ke hosting
# Jalankan script ini setelah upload files ke hosting

echo "Starting Laravel deployment..."

# 1. Install dependencies (jika composer tersedia)
if command -v composer &> /dev/null; then
    echo "Installing Composer dependencies..."
    composer install --optimize-autoloader --no-dev
else
    echo "Composer not found, skipping dependency installation"
fi

# 2. Set permissions yang benar
echo "Setting file permissions..."
chmod 755 storage/
chmod 755 bootstrap/cache/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 3. Create storage link
echo "Creating storage link..."
php artisan storage:link

# 4. Clear dan cache konfigurasi
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Caching configurations..."
php artisan config:cache
php artisan route:cache

# 5. Generate APP_KEY jika belum ada
if grep -q "APP_KEY=$" .env; then
    echo "Generating application key..."
    php artisan key:generate
fi

echo "Deployment completed!"
echo ""
echo "Don't forget to:"
echo "1. Update .env file with production settings"
echo "2. Set APP_ENV=production and APP_DEBUG=false"
echo "3. Update APP_URL with your domain"
echo "4. Configure database settings"
echo "5. Set proper SESSION_DOMAIN"

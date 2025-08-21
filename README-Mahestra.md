Mahestra Printing - Landing with Filament CMS

What I added:

-   Models: `HeroSection`, `Product`, `Contact`, `Testimonial`
-   Migrations for those models (2025*08_20_00000\*\_create*\*.php)
-   `HomeController@index` and `resources/views/landing.blade.php`
-   Updated `routes/web.php` to serve the landing page
-   Seed data in `database/seeders/DatabaseSeeder.php`

Quick setup (Windows PowerShell):

1. Install PHP dependencies (already present in project, but ensure vendor is up-to-date):

    composer install

2. Create .env from example and set DB. The project defaults to SQLite in `.env.example`.

    copy .env.example .env
    php artisan key:generate

3. If you want MySQL, update `.env` DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

4. Run migrations and seed:

    php artisan migrate
    php artisan db:seed

5. Filament admin setup (optional, not installed by me):

    composer require filament/filament
    php artisan vendor:publish --tag=filament-config
    php artisan make:filament-user

Then create Filament Resources for `HeroSection`, `Product`, `Contact`, `Testimonial` so admin can manage content via `/admin`.

Notes / Next steps:

-   I scaffolded DB models, migrations, and frontend. Filament resources are not yet created; I can scaffold them if you want.
-   Consider storing uploaded hero images to `storage/app/public` and running `php artisan storage:link`.

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (app()->environment('local')) {
            $root = request()->getSchemeAndHttpHost();
            URL::forceRootUrl($root);
            URL::forceScheme(request()->getScheme());
            URL::forceScheme('http');
        }

        // if (app()->environment('local') && request()?->getHttpHost()) {
        //     $root = request()->getSchemeAndHttpHost();
        //     URL::forceRootUrl($root);
        //     URL::forceScheme(request()->getScheme());
        // }
    }
}

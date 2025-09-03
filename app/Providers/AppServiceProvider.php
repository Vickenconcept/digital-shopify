<?php

namespace App\Providers;

use App\View\Composers\SiteSettingsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Make site settings available to all views
        View::composer(['components.main-layout', 'home'], SiteSettingsComposer::class);
    }
}

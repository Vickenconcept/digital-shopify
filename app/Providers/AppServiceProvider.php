<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\DigitalProduct;
use App\Models\Page;
use App\Observers\BlogObserver;
use App\Observers\CategoryObserver;
use App\Observers\DigitalProductObserver;
use App\Observers\PageObserver;
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
        View::composer(['components.main-layout'], SiteSettingsComposer::class);

        DigitalProduct::observe(DigitalProductObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        Page::observe(PageObserver::class);
    }
}

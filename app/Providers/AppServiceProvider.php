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
use App\Models\SiteSetting;
use App\View\Composers\SiteSettingsComposer;
use Illuminate\Support\Facades\Schema;
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
        $this->applyStripeSettingsFromDatabase();

        View::composer(['components.main-layout'], SiteSettingsComposer::class);

        DigitalProduct::observe(DigitalProductObserver::class);
        Blog::observe(BlogObserver::class);
        Category::observe(CategoryObserver::class);
        Page::observe(PageObserver::class);
    }

    private function applyStripeSettingsFromDatabase(): void
    {
        try {
            if (! Schema::hasTable('site_settings')) {
                return;
            }

            $settings = SiteSetting::first();

            if (! $settings) {
                return;
            }

            if (filled($settings->stripe_key)) {
                config(['services.stripe.key' => $settings->stripe_key]);
            }

            if (filled($settings->stripe_secret)) {
                config(['services.stripe.secret' => $settings->stripe_secret]);
            }

            if (filled($settings->stripe_webhook_secret)) {
                config(['services.stripe.webhook_secret' => $settings->stripe_webhook_secret]);
            }
        } catch (\Throwable) {
            //
        }
    }
}

<?php

namespace App\Providers;

use App\Services\FileUploadService;
use Illuminate\Support\ServiceProvider;

class FileUploadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FileUploadService::class, function ($app) {
            return new FileUploadService();
        });
    }

    public function boot(): void
    {
        //
    }
}
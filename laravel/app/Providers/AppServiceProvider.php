<?php

namespace App\Providers;

use App\Http\Services\CategoryService;
use App\Http\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        // $this->app->singleton(CategoryService::class, function ($app) {
        // return new CategoryService($app->make(ProductService::class));
        // });

        // $this->app->singleton(ProductService::class, function ($app) {
        // return new ProductService($app->make(CategoryService::class));
        // });

        $this->app->singleton(CategoryService::class, function () {
            return new CategoryService();
        });

        $this->app->singleton(ProductService::class, function () {
            return new ProductService();
        });
    }


    public function boot(): void
    {

    }
}

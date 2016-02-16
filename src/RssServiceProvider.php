<?php

namespace Spatie\Rss;

use Illuminate\Support\ServiceProvider;

class RssServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/../config/laravel-rss.php' => config_path('laravel-rss.php'),
        ], 'config');

        /*
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'skeleton');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/skeleton'),
        ], 'views');
        */
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-rss');
        include __DIR__.'/routes.php';
    }

}

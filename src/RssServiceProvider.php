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

        $rssConfig = config('laravel-rss');

        foreach($rssConfig['feeds'] as $feed){

            $this->app['router']->get($feed['url'], function() use ($feed){

                return $this->app->make(Rss::class)->feed($feed);

            });

        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-rss');

        /*
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-rss.php', 'laravel-rss');

        $this->app->singleton(Rss::class);

    }

}

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

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-rss');

        $this->getFeeds();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-rss.php', 'laravel-rss');

        $this->app->singleton(Rss::class);
    }

    /**
     * Gets feeds routes and generates feeds.
     */
    public function getFeeds()
    {
        foreach (config('laravel-rss.feeds') as $feed) {
            $this->app['router']->get($feed['url'], function () use ($feed) {

                return $this->app->make(Rss::class)->feed($feed);

            });
        }
    }
}

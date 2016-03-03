<?php

namespace Spatie\Feed;

use Illuminate\Support\ServiceProvider;

class FeedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-feed.php' => config_path('laravel-feed.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-feed');

        $this->registerFeeds();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-feed.php', 'laravel-feed');

        $this->app->singleton(Feed::class);
    }

    /**
     * Gets feeds routes and generates feeds.
     */
    protected function registerFeeds()
    {
        collect(config('laravel-feed.feeds'))->each(function ($feedConfiguration) {
            if (!$feedConfiguration['url']) {
                return;
            }
            $this->registerRoute($feedConfiguration);
        });
    }

    protected function registerRoute($feedConfiguration)
    {
        $this->app['router']->get($feedConfiguration['url'], function () use ($feedConfiguration) {

            return $this->app->make(Feed::class)->getFeedResponse($feedConfiguration);

        });
    }
}

<?php

namespace Spatie\Feed;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Illuminate\View\View;

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

        $this->bindFeedsLinks();
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
     * Generates feeds.
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

    /**
     * Gets feeds routes.
     *
     * @param $feedConfiguration
     */
    protected function registerRoute($feedConfiguration)
    {
        $this->app['router']->get($feedConfiguration['url'], function () use ($feedConfiguration) {

            $feed = new Feed($feedConfiguration);

            return $feed->getFeedResponse();
        });
    }

    /**
     * Generates autodiscovery links for feeds.
     */
    public function bindFeedsLinks()
    {
        $this->app->make(Dispatcher::class)->listen('composing: laravel-feed::feed-links', function (View $view) {
            $view->with(['feeds' => config('laravel-feed.feeds')]);
        });
    }
}

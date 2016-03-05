<?php

namespace Spatie\Feed;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Illuminate\View\View;

class FeedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-feed.php' => config_path('laravel-feed.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-feed');

        $this->bindFeedLinks();

        $this->registerFeedRoutes();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-feed.php', 'laravel-feed');
    }

    protected function registerFeedRoutes()
    {
        collect(config('laravel-feed.feeds'))->each(function (array $feedConfiguration) {
            if (!$feedConfiguration['url']) {
                return;
            }
            $this->registerRoute($feedConfiguration);
        });
    }

    protected function registerRoute(array $feedConfiguration)
    {
        $this->app['router']->get($feedConfiguration['url'], function () use ($feedConfiguration) {

            $feed = new Feed($feedConfiguration);

            return $feed->getFeedResponse();
        });
    }

    public function bindFeedLinks()
    {
        $this->app
            ->make(Dispatcher::class)
            ->listen('composing: laravel-feed::feed-links', function (View $view) {
                $view->with(['feeds' => config('laravel-feed.feeds')]);
            });
    }
}

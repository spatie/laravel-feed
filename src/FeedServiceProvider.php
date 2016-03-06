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
            __DIR__.'/../config/laravel-feed.php' => config_path('laravel-feed.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-feed');

        $this->bindFeedLinks();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-feed.php', 'laravel-feed');

        $this->registerRouteMacro();
    }

    protected function registerRouteMacro()
    {
        $router = $this->app['router'];

        $router->macro('feeds', function ($baseUrl = '') use ($router) {

            collect(config('laravel-feed.feeds'))->each(function (array $feedConfiguration) use ($router, $baseUrl) {

                $router->get($feedConfiguration['url'], function () use ($router, $baseUrl, $feedConfiguration) {

                    //TO DO: make this more robust
                    $feedConfiguration['url'] = $baseUrl.DIRECTORY_SEPARATOR.$feedConfiguration['url'];

                    $feed = new Feed($feedConfiguration);

                    return $feed->getFeedResponse();
                });
            });
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

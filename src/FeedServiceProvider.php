<?php

namespace Spatie\Feed;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class FeedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__.'/../config/laravel-feed.php' => config_path('laravel-feed.php')], 'config');
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
            foreach (config('laravel-feed.feeds') as $index => $feedConfiguration) {
                $separator = starts_with($feedConfiguration['url'], '/') ? '' : '/';
                $fullUrl = $baseUrl.$separator.$feedConfiguration['url'];
                $router->get($fullUrl, ['as' => "spatieLaravelFeed{$index}", function () use ($fullUrl, $feedConfiguration) {
                    $feedConfiguration['url'] = $fullUrl;
                    $feed = new Feed($feedConfiguration);

                    return $feed->getFeedResponse();
                }]);
            }
        });
    }

    public function bindFeedLinks()
    {
        $feeds = [];

        foreach (config('laravel-feed.feeds') as $index => $feedConfig) {
            $feeds[] = ['title' => $feedConfig['title'], 'url' => $this->app['url']->route("spatieLaravelFeed{$index}")];
        }

        $this->app->make(Dispatcher::class)->listen('composing: laravel-feed::feed-links', function (View $view) use ($feeds) {
            $view->with(compact('feeds'));
        });
    }
}

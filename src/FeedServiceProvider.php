<?php

namespace Spatie\Feed;

use Illuminate\View\View;
use Spatie\Feed\Helpers\Path;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class FeedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-feed.php' => config_path('laravel-feed.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-feed');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-feed'),
        ], 'views');

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
                $router->get(
                    Path::merge($baseUrl, $feedConfiguration['url']),
                    ['as' => "spatieLaravelFeed{$index}", 'uses' => '\Spatie\Feed\Http\FeedController@feed']
                );
            }
        });
    }

    public function bindFeedLinks()
    {
        $this->app->make(Dispatcher::class)->listen('composing: laravel-feed::feed-links', function (View $view) {
            $feeds = collect(config('laravel-feed.feeds'))->map(function ($feedConfig, $index) {
                return [
                    'title' => $feedConfig['title'],
                    'url' => $this->app['url']->route("spatieLaravelFeed{$index}"),
                ];
            });

            $view->with(compact('feeds'));
        });
    }
}

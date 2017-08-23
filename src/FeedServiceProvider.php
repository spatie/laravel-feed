<?php

namespace Spatie\Feed;

use Illuminate\View\View;
use Spatie\Feed\Helpers\Path;
use Illuminate\Events\Dispatcher;
use Spatie\Feed\Http\FeedController;
use Illuminate\Support\ServiceProvider;

class FeedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/feed.php' => config_path('feed.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'feed');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/feed'),
        ], 'views');

        $this->bindFeedLinks();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/feed.php', 'feed');

        $this->registerRouteMacro();
    }

    protected function registerRouteMacro()
    {
        $router = $this->app['router'];

        $router->macro('feeds', function ($baseUrl = '') use ($router) {
            foreach (config('feed.feeds') as $name => $configuration) {
                $url = Path::merge($baseUrl, $configuration['url']);

                $router->get($url, FeedController::class)->name("feeds.{$name}");
            }
        });
    }

    public function bindFeedLinks()
    {
        $this->app->make(Dispatcher::class)->listen('composing: feed::feed-links', function (View $view) {
            $feeds = collect(config('feed.feeds'))->map(function ($feedConfig, $index) {
                return [
                    'title' => $feedConfig['title'],
                    'url' => $this->app['url']->route("feeds.{$index}"),
                ];
            });

            $view->with(compact('feeds'));
        });
    }
}

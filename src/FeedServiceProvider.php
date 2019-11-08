<?php

namespace Spatie\Feed;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Feed\Helpers\Path;
use Spatie\Feed\Http\FeedController;

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

        $this->registerLinksComposer();
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

                $router->get($url, '\\'.FeedController::class)->name("feeds.{$name}");
            }
        });
    }

    public function registerLinksComposer()
    {
        View::composer('feed::links', function ($view) {
            $view->with('feeds', $this->feeds());
        });
    }

    protected function feeds()
    {
        return collect(config('feed.feeds'));
    }
}

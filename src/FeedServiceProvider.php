<?php

namespace Spatie\Feed;

use Spatie\Feed\Components\FeedLinks;
use Spatie\Feed\Helpers\Path;
use Spatie\Feed\Http\FeedController;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FeedServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-feed')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComposer('feed::links', function ($view) {
                $view->with('feeds', $this->feeds());
            })
            ->hasViewComponent('', FeedLinks::class);
    }

    public function packageRegistered()
    {
        $this->registerRouteMacro();
    }

    protected function registerRouteMacro(): void
    {
        $router = $this->app['router'];

        $router->macro('feeds', function ($baseUrl = '') use ($router) {
            foreach (config('feed.feeds') as $name => $configuration) {
                $url = Path::merge($baseUrl, $configuration['url']);

                $router->get($url, '\\'.FeedController::class)->name("feeds.{$name}");
            }
        });
    }

    protected function feeds()
    {
        return collect(config('feed.feeds'));
    }
}

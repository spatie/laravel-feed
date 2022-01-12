<?php

namespace Spatie\Feed;

use Illuminate\Support\Collection;
use Spatie\Feed\Components\FeedLinks;
use Spatie\Feed\Helpers\ConfigurationValidator;
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

    public function packageBooted()
    {
        if (! app()->runningUnitTests()) {
            ConfigurationValidator::validate();
        }
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

    protected function feeds(): Collection
    {
        return collect(config('feed.feeds'));
    }
}

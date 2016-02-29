<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\FeedServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [FeedServiceProvider::class];
    }
    protected function getEnvironmentSetUp($app)
    {
        $feed = [
            [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAllOnline',
                'url' => '/feed1',
                'title' => 'Feed 1',
                'description' => 'This is feed 1 from the unit tests',
                'updated' => \Carbon\Carbon::now()->toATOMString(),
            ],
            [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAllOnline',
                'url' => '/feed2',
                'title' => 'Feed 2',
                'description' => 'This is feed 2 from the unit tests',
                'updated' => \Carbon\Carbon::now()->toATOMString(),
            ],
        ];

        $app['config']->set('laravel-feed.feeds', $feed);
    }
}
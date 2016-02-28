<?php

namespace Spatie\Rss\Test;

use Spatie\Rss\RssServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [RssServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $feed = [
            [
                'items' => 'Spatie\Rss\Test\DummyRepository@getAllOnline',

                'url' => '/feed1',
                'meta' => [
                    'link' => 'https://localhost/feed1',
                    'title' => 'Feed 1',
                    'updated' => \Carbon\Carbon::now()->toATOMString(),
                    'description' => 'This is feed 1 from the unit tests',
                ],

            ],
            [
                'items' => 'Spatie\Rss\Test\DummyRepository@getAllOnline',

                'url' => '/feed2',
                'meta' => [
                    'link' => 'https://localhost/feed1',
                    'title' => 'Feed 1',
                    'updated' => \Carbon\Carbon::now()->toATOMString(),
                    'description' => 'This is feed 2 from the unit tests',
                ],
            ],
        ];

        $app['config']->set('laravel-rss.feeds', $feed);
    }
}

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

                'url'   => '/en/myfeed',
                'meta'  => [
                    'link'          => "http://blender.192.168.10.10.xip.io/en/feed",
                    'title'         => 'News en',
                    'updated'       => \Carbon\Carbon::now()->toATOMString(),
                    'description'   => '...',
                    'irong'         => 'ksngkrgn'
                ]

            ],
            [
                'items' => 'Spatie\Rss\Test\DummyRepository@getAllOnline',

                'url'   => '/nl/myfeed',
                'meta'  => [
                    'link'          => "http://blender.192.168.10.10.xip.io/nl/feed",
                    'title'         => 'News nl',
                    'updated'       => \Carbon\Carbon::now()->toATOMString(),
                    'description'   => '...',
                    'irong'         => 'ksngkrgn'
                ]
            ],
        ];

        $app['config']->set('laravel-rss.feeds', $feed);

    }
}

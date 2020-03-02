<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Spatie\Feed\FeedServiceProvider;
use Spatie\Snapshots\MatchesSnapshots;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use MatchesSnapshots;

    public function setUp(): void
    {
        Carbon::setTestNow(Carbon::create(2016, 1, 1, 0, 0, 0)
            ->setTimezone('Europe/Brussels')
            ->startOfDay());

        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [FeedServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $feed = [
            [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed1',
                'title' => 'Feed 1',
                'description' => 'This is feed 1 from the unit tests',
                'language' => 'en-US',
            ],
            [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed2',
                'title' => 'Feed 2',
                'description' => 'This is feed 2 from the unit tests',
                'language' => 'en-US',
            ],
            [
                'items' => ['Spatie\Feed\Test\DummyRepository@getAllWithArguments', 'first'],
                'url' => '/feed3',
                'title' => 'Feed 3',
                'description' => 'This is feed 3 from the unit tests',
                'language' => 'en-US',
            ],
            [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed-with-custom-view',
                'title' => 'Feed with Custom View',
                'description' => 'This is a feed that uses custom views from the unit tests',
                'language' => 'en-US',
                'view' => 'feed::links',
            ],
            [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed1.rss',
                'title' => 'Feed 1 RSS',
                'description' => 'This is feed 1 as RSS from the unit tests',
                'language' => 'en-US',
                'view' => 'feed::rss',
                'type' => 'application/rss+xml',
            ],
        ];

        $app['config']->set('feed.feeds', $feed);

        $app['config']->set('app.debug', true);

        $this->setUpRoutes($app);
    }

    protected function setUpRoutes($app)
    {
        $app['router']->feeds('feedBaseUrl');

        $app['router']->get('/test-route', function () use ($app) {
            return $app['view']->make('feed::links');
        });
    }
}

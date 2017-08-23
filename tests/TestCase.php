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

    public function setUp()
    {
        Carbon::setTestNow(Carbon::create(2016, 1, 1, 0, 0, 0)
            ->setTimezone('Europe/Brussels')
            ->startOfDay());

        parent::setUp();

        $this->disableExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [FeedServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $feed = [
            [
                'items'       => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url'         => '/feed1',
                'title'       => 'Feed 1',
                'description' => 'This is feed 1 from the unit tests',
            ],
            [
                'items'       => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url'         => '/feed2',
                'title'       => 'Feed 2',
                'description' => 'This is feed 2 from the unit tests',
            ],
            [
                'items'       => ['Spatie\Feed\Test\DummyRepository@getAllWithArguments', 'first'],
                'url'         => '/feed3',
                'title'       => 'Feed 3',
                'description' => 'This is feed 3 from the unit tests',
            ],
        ];

        $app['config']->set('laravel-feed.feeds', $feed);

        $app['config']->set('app.debug', true);

        $this->setUpRoutes($app);
    }

    protected function setUpRoutes($app)
    {
        $app['router']->feeds('feedBaseUrl');

        $app['router']->get('/test-route', function () use ($app) {
            return $app['view']->make('laravel-feed::feed-links');
        });
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Exception $exception)
            {
            }

            public function render($request, Exception $exception)
            {
                throw $exception;
            }
        });
    }
}

<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Illuminate\Support\Str;
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
            'feed1' => [
                'items' => ['Spatie\Feed\Test\DummyRepository', 'getAll'],
                'url' => '/feed1',
                'title' => 'Feed 1',
                'description' => 'This is feed 1 from the unit tests',
                'language' => 'en-US',
                'image' => 'http://localhost/image.jpg',
                'format' => 'atom',
            ],
            'feed2' => [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed2',
                'title' => 'Feed 2',
                'description' => 'This is feed 2 from the unit tests',
                'language' => 'en-US',
                'image' => 'http://localhost/image.jpg',
                'format' => 'atom',
            ],
            'feed3' => [
                'items' => ['Spatie\Feed\Test\DummyRepository', 'getAllWithArguments', 'first'],
                'url' => '/feed3',
                'title' => 'Feed 3',
                'description' => 'This is feed 3 from the unit tests',
                'language' => 'en-US',
                'image' => 'http://localhost/image.jpg',
                'format' => 'atom',
            ],
            'feedcustom' => [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed-with-custom-view',
                'title' => 'Feed with Custom View',
                'description' => 'This is a feed that uses custom views from the unit tests',
                'language' => 'en-US',
                'image' => 'http://localhost/image.jpg',
                'view' => 'feed::links',
                'format' => 'atom',
            ],
            'feedrss' => [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed1.rss',
                'title' => 'Feed 1 RSS',
                'description' => 'This is feed 1 as RSS from the unit tests',
                'language' => 'en-US',
                'image' => 'http://localhost/image.jpg',
                'view' => 'feed::rss',
                'type' => 'application/rss+xml',
                'format' => 'rss',
            ],
            'feedjson' => [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'url' => '/feed1.json',
                'title' => 'Feed 1 JSON',
                'description' => 'This is feed 1 as JSON from the unit tests',
                'language' => 'en-US',
                'image' => 'http://localhost/image.jpg',
                'view' => 'feed::json',
                'type' => 'application/feed+json',
                'format' => 'json',
            ],
        ];

        $app['config']->set('feed.feeds', $feed);

        $app['config']->set('app.debug', true);

        $this->setUpRoutes($app);
    }


    private function renderBlade($app, string $template, array $data = [])
    {
        $tempDirectory = dirname(__FILE__) . '/temp';

        if (!in_array($tempDirectory, $app['view']->getFinder()->getPaths())) {
            $app['view']->addLocation($tempDirectory);
        }

        $tempFile = $tempDirectory . '/laravel-feed-' . Str::random(10) . '.blade.php';
        file_put_contents($tempFile, $template);

        return $app['view']->make(Str::before(basename($tempFile), '.blade.php'))->with($data);
    }


    protected function setUpRoutes($app)
    {
        $app['router']->feeds('feedBaseUrl');

        $app['router']->get('/test-route', function () use ($app) {
            return $app['view']->make('feed::links');
        });

        $app['router']->get('/test-route-blade-component', function () use ($app) {
            return $this->renderBlade($app, '<x-feed-links />');
        });
    }
}

<?php

namespace Spatie\Feed\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Feed\Feed;
use Spatie\TestTime\TestTime;

class FeedTest extends TestCase
{
    protected array $feedNames = ['feed1', 'feed2', 'feed3', 'feed1.rss', 'feed1.json'];

    /** @test */
    public function all_feeds_are_available_on_their_registered_routes()
    {
        collect($this->feedNames)->each(function (string $feedName) {
            $this->get("/feedBaseUrl/{$feedName}")->assertStatus(200);
        });
    }

    /** @test */
    public function all_feed_items_have_expected_data()
    {
        collect($this->feedNames)->each(function (string $feedName) {
            $generatedFeedContent = $this->get("/feedBaseUrl/{$feedName}")->getContent();

            $this->assertMatchesSnapshot($generatedFeedContent);
        });
    }

    /** @test */
    public function it_can_render_all_feed_links_via_a_view()
    {
        $feedLinksHtml = $this->get('/test-route')->getContent();

        $this->assertMatchesSnapshot($feedLinksHtml);
    }

    /** @test */
    public function it_can_render_all_feed_links_via_the_blade_component()
    {
        $feedLinksHtml = trim($this->get('/test-route-blade-component')->getContent());

        $this->assertMatchesSnapshot($feedLinksHtml);
    }

    /** @test */
    public function all_feed_items_can_have_a_custom_view()
    {
        $response = $this->get('/feedBaseUrl/feed-with-custom-view');

        $response->assertStatus(200);

        $response->assertViewIs('feed::links');
    }

    /** @test */
    public function it_can_accept_an_array()
    {
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $feed = new Feed('title', collect([
            [
                'id' => 1,
                'authorName' => 'John',
                'authorEmail' => 'john@test.test',
                'title' => 'Song A',
                'updated' => now(),
                'summary' => 'summary A',
                'link' => 'link A',
            ],
            [
                'id' => 2,
                'authorName' => 'paul',
                'authorEmail' => 'paul@test.test',
                'title' => 'Song B',
                'updated' => now(),
                'summary' => 'summary B',
                'link' => 'link B',
            ],
        ]));

        $response = $feed->toResponse(Request::capture());

        $this->assertMatchesSnapshot($response->content());
    }

    /** @test */
    public function it_returns_the_correct_content_type()
    {
        $feeds = [
            'feed1' => 'application/xml',
            'feed1.rss' => 'application/xml',
            'feed1.json' => 'application/json',
        ];

        collect($feeds)->each(function (string $contentType, $feedName) {
            $response = $this->get("/feedBaseUrl/{$feedName}");

            $response->assertStatus(200);

            $this->assertEquals(Str::before($response->headers->get('content-type'), ';'), $contentType);
        });
    }

    /** @test */
    public function it_caches_items_when_cache_ttl_is_greater_than_zero()
    {
        Cache::spy();

        $responses = [
            $this->get('/feedBaseUrl/feed1-cached.json'),
            $this->get('/feedBaseUrl/feed1-cached.json'),
            $this->get('/feedBaseUrl/feed1-cached.json'),
        ];

        collect($responses)->each(fn ($resp) => $resp->assertStatus(200));

        Cache::shouldHaveReceived('remember')
            ->times(count($responses))
            ->withAnyArgs();
    }

    /** @test */
    public function it_does_not_cache_items_when_cache_ttl_is_zero()
    {
        Cache::shouldReceive('remember')->never();

        $responses = [
            $this->get('/feedBaseUrl/feed1.json'),
            $this->get('/feedBaseUrl/feed1.json'),
        ];

        collect($responses)->each(fn ($resp) => $resp->assertStatus(200));
    }

    /** @test */
    public function it_returns_cached_items_when_cache_ttl_is_greater_than_zero()
    {
        $responses = [];

        // initial response is cached for 10 seconds (see TestCase class)
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');
        $responses[] = $this->get('/feedBaseUrl/feed1-cached.json');

        // cause an an item to be added while items are still cached
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:05');
        $responses[] = $this->get('/feedBaseUrl/feed1-cached.json?add=1');

        // cause an item to be added after the initial cache expires
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:55');
        $responses[] = $this->get('/feedBaseUrl/feed1-cached.json?add=1');

        // get content of each response, removing date strings
        $content = collect($responses)
            ->map(fn ($resp) => preg_replace('~<pubDate>.+</pubDate>~', '', $resp->getContent()))
            ->all();

        // first two responses are the same even though an item was added because we received a
        // cached response on the second request.
        $this->assertSame($content[0], $content[1]);

        // the third request did not return cached data, so it's different than the first response
        $this->assertNotSame($content[0], $content[2]);

        $this->assertMatchesSnapshot($content);
    }

}

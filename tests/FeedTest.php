<?php

namespace Spatie\Feed\Test;

use Illuminate\Http\Request;
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
}

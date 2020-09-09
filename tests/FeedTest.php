<?php

namespace Spatie\Feed\Test;

use Illuminate\Http\Request;
use Spatie\Feed\Feed;
use Spatie\TestTime\TestTime;

class FeedTest extends TestCase
{
    protected array $feedNames = ['feed1', 'feed2', 'feed3', 'feed1.rss'];

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
                'author' => 'John',
                'title' => 'Song A',
                'updated' => now(),
                'summary' => 'summary A',
                'link' => 'link A',
            ],
            [
                'id' => 2,
                'author' => 'paul',
                'title' => 'Song B',
                'updated' => now(),
                'summary' => 'summary B',
                'link' => 'link B',

            ],
        ]));

        $response = $feed->toResponse(Request::capture());

        $this->assertMatchesSnapshot($response->content());
    }
}

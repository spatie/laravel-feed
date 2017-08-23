<?php

namespace Spatie\Feed\Test;

class FeedTest extends TestCase
{
    protected $feedNames = ['feed1', 'feed2', 'feed3'];

    /** @test */
    public function all_feeds_are_available_on_their_registered_routes()
    {
        collect($this->feedNames)->each(function (string $feedName) {
            $response = $this->call('GET', "/feedBaseUrl/{$feedName}");

            $this->assertEquals(200, $response->getStatusCode());
        });
    }

    /** @test */
    public function all_feed_items_have_expected_data()
    {
        collect($this->feedNames)->each(function (string $feedName) {
            $generatedFeedContent = $this->call('GET', "/feedBaseUrl/{$feedName}")->getContent();

            $this->assertMatchesSnapshot($generatedFeedContent);
        });
    }

    /** @test */
    public function it_can_render_all_feed_links_via_a_view()
    {
        $feedLinksHtml = $this->call('GET', '/test-route')->getContent();

        $this->assertMatchesSnapshot($feedLinksHtml);
    }
}

<?php

namespace Spatie\Feed\Test;

class FeedTest extends TestCase
{
    /** @var array */
    protected $feedNames = ['feed1', 'feed2', 'feed3'];

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

    /**
     * When using CDATA in xml, there is no need to escape HTML characters; however,
     * the one thing that must be escaped is the closing CDATA tag, "]]>".
     * This is done by splitting up the output into two (or more) tags.
     *
     * See: https://stackoverflow.com/a/223782/2544756
     *
     * @test
     */
    public function feed_data_is_escaped_properly()
    {
        $feedContent = $this->get('/feedBaseUrl/feed-with-special-chars')->getContent();

        $this->assertMatchesSnapshot($feedContent);
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
}

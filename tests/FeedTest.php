<?php

namespace Spatie\Feed\Test;

class FeedTest extends TestCase
{
    /** @test */
    public function it_registers_routes_where_feeds_will_be_available()
    {
        $this->assertEquals(200, $this->call('GET', '/feed1')->getStatusCode());
        $this->assertEquals(200, $this->call('GET', '/feed2')->getStatusCode());
    }

    /** @test */
    public function a_feed_contains_meta_data()
    {
        $content = $this->call('GET', '/feed1')->getContent();

        $metaData = [
            '<description>This is feed 1 from the unit tests</description>',
            '<link href="http://localhost/feed1">',
            '<updated>',
        ];

        foreach ($metaData as $metaDataItem) {
            $this->assertContains($metaDataItem, $content);
        }
    }

    /** @test */
    public function a_feed_contains_all_selected_models()
    {
        $content = $this->call('GET', '/feed1')->getContent();
        $this->assertEquals(5, substr_count($content, '<entry>'));
    }
}
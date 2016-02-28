<?php

namespace Spatie\Rss\Test;

class RssTest extends TestCase
{
    /** @test */
    public function it_registers_routes_where_feeds_will_be_available()
    {
        $this->assertEquals(200, $this->call('GET', '/en/myfeed')->getStatusCode());
        $this->assertEquals(200, $this->call('GET', '/nl/myfeed')->getStatusCode());
    }

    /** @test */
    public function a_feed_contains_meta_data()
    {
        $content = $this->call('GET', '/en/myfeed')->getContent();

        $metaData = [
            '<description>...</description>',
            '<link href="http://blender.192.168.10.10.xip.io/en/feed">',
            '<updated>',

        ];

        foreach ($metaData as $metaDataItem) {
            $this->assertContains($metaDataItem, $content);
        }
    }

    /** @test */
    public function a_feed_contains_all_selected_models()
    {
        $content = $this->call('GET', '/en/myfeed')->getContent();
        $this->assertEquals(5, substr_count($content, '<entry>'));
    }
}

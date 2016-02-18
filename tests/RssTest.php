<?php

namespace Spatie\Rss\Test;

class RssTest extends TestCase
{
    /**
     * @test
     */
    public function it_registers_route()
    {
        $this->assertEquals(200, $this->call('GET', '/en/myfeed')->getStatusCode());
        $this->assertEquals(200, $this->call('GET', '/nl/myfeed')->getStatusCode());
    }

    /**
     * @test
     */
    public function feed_has_all_models()
    {
        $content = $this->call('GET', '/en/myfeed')->getContent();
        $this->assertEquals(5, substr_count($content, '<entry>'));
    }

    /**
     * @test
     * @dataProvider  provider_feed_has_meta
     */
    public function feed_has_meta($stringToCheck)
    {
        $content = $this->call('GET', '/en/myfeed')->getContent();
        $this->assertTrue(str_contains($content, $stringToCheck));
    }

    /**
     * @dataProvider
     */
    public function provider_feed_has_meta() : array
    {
        return [
            ['<description>...</description>'],
            ['<link href="http://blender.192.168.10.10.xip.io/en/feed">'],
            ['<updated>'],

        ];
    }
}

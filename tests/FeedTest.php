<?php

namespace Spatie\Feed\Test;

use Illuminate\Filesystem\Filesystem as File;
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
    public function a_feed_contains_xml_content()
    {
        $content = $this->call('GET', '/feed1')->getContent();
        $file = 'tests/feeds.xml';
        app(File::class)->put($file, $content);
        $xml_reader = new \XMLReader();
        $xml_reader->open($file);
        $xml_reader->setParserProperty($xml_reader::VALIDATE, true);
        $this->assertTrue($xml_reader->isValid());
    }

    /** @test */
    public function a_feed_contains_all_selected_models()
    {
        $content = $this->call('GET', '/feed1')->getContent();
        $this->assertEquals(5, substr_count($content, '<entry>'));
    }

    /** @test */
    public function a_feed_contains_a_expected_data()
    {
        $content = $this->call('GET', '/feed1')->getContent();
        $file = 'tests/feeds.xml';
        app(File::class)->put($file, $content);
        app(File::class)->get($file);
    }
}
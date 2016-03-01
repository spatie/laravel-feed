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
        $contents = $this->getContent();
        $metaData = $this->getMetaData();
        for ($i = 0; $i < count($contents); ++$i) {
            foreach ($metaData[$i] as $metaDataItem) {
                $this->assertContains($metaDataItem, $contents[$i]);
            }
        }
    }

    /** @test */
    public function a_feed_contains_xml_content()
    {
        $this->validate_xml($this->getContent());
    }

    private function validate_xml($contents)
    {
        for ($i = 0; $i < count($contents); ++$i) {
            $file = $this->makeXmlFiles($i, $contents[$i]);
            $xml_reader = new \XMLReader();
            $xml_reader->open($file);
            $xml_reader->setParserProperty($xml_reader::VALIDATE, true);
            $this->assertTrue($xml_reader->isValid());
        }
    }

    /** @test */
    public function a_feed_contains_all_selected_models()
    {
        foreach ($this->getContent() as $content) {
            $this->assertEquals(5, substr_count($content, '<entry>'));
        }
    }

    /** @test */
    public function all_feed_items_have_expected_data()
    {
        $this->check_if_feed_has_expected_content($this->getContent());
    }

    private function check_if_feed_has_expected_content($contents)
    {
        for ($i = 0; $i < count($contents); ++$i) {
            $this->makeXmlFiles($i, $contents[$i]);
            $saved_file = app(File::class)->get('tests/xml-files/feeds_'.$i.'.xml');
            $file = app(File::class)->get('tests/feeds_'.$i.'.xml');
            $this->assertEquals($file, $saved_file);
        }
    }
    private function getMetaData()
    {
        return [
            [
                '<description>This is feed 1 from the unit tests</description>',
                '<link href="http://localhost/feed1">',
                '<updated>',
            ],
            [
                '<description>This is feed 2 from the unit tests</description>',
                '<link href="http://localhost/feed2">',
                '<updated>',
            ],
        ];
    }

    private function getContent()
    {
        return [
            $this->call('GET', '/feed1')->getContent(),
            $this->call('GET', '/feed2')->getContent(),
        ];
    }

    private function makeXmlFiles($i, $content)
    {
        $file = 'tests/feeds_'.$i.'.xml';
        app(File::class)->put($file, $content);

        return $file;
    }
}

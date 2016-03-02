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
        $i = 0;
        foreach ($this->getContent() as $content) {
            $this->assertTrue($this->validateXml($i, $content));
            ++$i;
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
        $i = 0;
        foreach ($this->getContent() as $content) {
            $this->assertEquals(file_get_contents('tests/stubs/feeds_'.$i.'.xml'), $content);
            ++$i;
        }
    }

    protected function getMetaData()
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

    protected function getContent()
    {
        return [
            $this->call('GET', '/feed1')->getContent(),
            $this->call('GET', '/feed2')->getContent(),
        ];
    }

    protected function validateXml($i, $content)
    {
        $file = 'tests/temp/feeds_'.$i.'.xml';
        file_put_contents($file, $content);
        $xml_reader = new \XMLReader();
        $xml_reader->open($file);
        $xml_reader->setParserProperty($xml_reader::VALIDATE, true);
        unlink($file);

        return $xml_reader->isValid();
    }
}

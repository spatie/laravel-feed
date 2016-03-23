<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\Exceptions\InvalidConfiguration;
use Spatie\Feed\Feed;
use XMLReader;

class FeedTest extends TestCase
{
    protected $feedNames = ['feed1', 'feed2'];

    /** @test */
    public function all_feeds_are_available_on_their_registered_routes()
    {
        collect($this->feedNames)->each(function (string $feedName) {

            $this->assertEquals(200, $this->call('GET', "/feedBaseUrl/{$feedName}")->getStatusCode());

        });
    }

    /** @test */
    public function all_feeds_contain_valid_xml_content()
    {
        collect($this->feedNames)->each(function (string $feedName) {

            $generatedFeedContent = $this->call('GET', "/feedBaseUrl/{$feedName}")->getContent();

            $this->assertTrue($this->validateXml($generatedFeedContent));

        });
    }

    /** @test */
    public function all_feed_items_have_expected_data()
    {
        collect($this->feedNames)->each(function (string $feedName) {

            $stubContent = file_get_contents("tests/stubs/{$feedName}.xml");
            $generatedFeedContent = $this->call('GET', "/feedBaseUrl/{$feedName}")->getContent();
//            file_put_contents("tests/stubs/{$feedName}.xml", $generatedFeedContent);

            $this->assertEquals($stubContent, $generatedFeedContent);
        });
    }

    /** @test */
    public function it_can_render_all_feed_links_via_a_view()
    {
        $feedLinksHtml = $this->call('GET', '/test-route')->getContent();
        $stubContent = file_get_contents('tests/stubs/feeds-links.xml');

        $this->assertEquals($stubContent, $feedLinksHtml);
    }

    /** @test */
    public function it_wil_throw_an_expection_if_the_items_config_is_not_filled_properly()
    {
        $this->expectException(InvalidConfiguration::class);

        $feedConfig = [
            'items' => 'invalid',
            'url' => '/feed',
            'title' => 'Title',
        ];

        new Feed($feedConfig);
    }

    protected function validateXml(string $content) : bool
    {
        $file = 'tests/temp/validate.xml';

        file_put_contents($file, $content);

        $xmlReader = new XMLReader();
        $xmlReader->open($file);
        $xmlReader->setParserProperty($xmlReader::VALIDATE, true);

        return $xmlReader->isValid();
    }
}

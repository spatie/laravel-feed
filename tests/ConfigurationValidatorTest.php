<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\Exceptions\InvalidConfiguration;
use Spatie\Feed\Helpers\ConfigurationValidator;

class ConfigurationValidatorTest extends TestCase
{

    /** @test */
    public function it_validates_feed_formats()
    {
        $exceptionCounter = 0;
        $formats = ['atom', 'json', 'rss', 'other'];

        foreach ($formats as $format) {
            try {
                ConfigurationValidator::validate([
                    'feed1' => [
                        'view' => 'feed::rss',
                        'format' => $format,
                    ],
                ]);
            } catch (InvalidConfiguration $e) {
                $exceptionCounter++;
            }
        }

        $this->assertEquals(1, $exceptionCounter);
    }

    /** @test */
    public function it_throws_an_exception_for_invalid_feed_types()
    {
        $this->expectException(InvalidConfiguration::class);

        ConfigurationValidator::validate([
            'feed1' => [
                'view' => 'feed::rss',
                'format' => 'test',
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_for_an_invalid_items_value()
    {
        $exceptionCounter = 0;

        $invalidItems = [[], null, '', ['test']];
        $validItems = ['Model@getAll', ['App\\Model', 'getItems'], ['App\\Model', 'getItems', 'param1']];

        $items = array_merge($invalidItems, $validItems);

        foreach ($items as $itemsValue) {
            try {
                ConfigurationValidator::validateResolver('feed1', $itemsValue);
            } catch (InvalidConfiguration $e) {
                $exceptionCounter++;
            }
        }

        $this->assertEquals(count($invalidItems), $exceptionCounter);
    }

    /** @test */
    public function it_throws_an_exception_for_an_invalid_view()
    {
        $exceptionCounter = 0;
        $views = ['', 'feed::missing', null, 'feed::rss'];

        foreach ($views as $view) {
            try {
                ConfigurationValidator::validate([
                    'feed1' => [
                        'view' => $view,
                        'format' => 'json',
                    ],
                ]);
            } catch (InvalidConfiguration $e) {
                $exceptionCounter++;
            }
        }

        $this->assertEquals(2, $exceptionCounter);
    }
}

<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\Exceptions\InvalidConfiguration;
use Spatie\Feed\Helpers\ConfigurationValidator;

class ConfigurationValidatorTest extends TestCase
{

    /** @test */
    public function it_successfully_validates_valid_configurations()
    {
        $exceptionCounter = 0;
        $formats = ['atom', 'json', 'rss'];

        foreach($formats as $format) {
            try {
                ConfigurationValidator::validate([
                    'feed1' => [
                        'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                        'view' => 'feed::rss',
                        'format' => $format,
                    ],
                ]);
            } catch(InvalidConfiguration $e) {
                $exceptionCounter++;
            }
        }

        $this->assertEquals(0, $exceptionCounter);
    }

    /** @test */
    public function it_throws_an_exception_for_invalid_feed_types()
    {
        $this->expectException(InvalidConfiguration::class);

        ConfigurationValidator::validate([
            'feed1' => [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'view' => 'feed::rss',
                'format' => 'test',
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_for_an_invalid_items_value()
    {
        $this->expectException(InvalidConfiguration::class);

        ConfigurationValidator::validate([
            'feed1' => [
                'items' => '',
                'view' => 'feed::rss',
                'format' => 'rss',
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_for_an_invalid_view()
    {
        $this->expectException(InvalidConfiguration::class);

        ConfigurationValidator::validate([
            'feed1' => [
                'items' => 'Spatie\Feed\Test\DummyRepository@getAll',
                'view' => 'feed::missing',
                'format' => 'json',
            ],
        ]);
    }
}

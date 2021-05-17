<?php


namespace Spatie\Feed\Test;


use Spatie\Feed\Exceptions\InvalidConfigFile;

class ConfigFileTest extends TestCase
{
    /** @test */
    public function ensure_that_the_items_key_in_the_config_is_array()
    {
        $configItems = config('feed.feeds');

        foreach ($configItems as $configItem) {
            if (is_array($configItem['items'])) {
                $this->assertIsArray($configItem['items']);
                $this->assertArrayHasKey(1, $configItem['items']);
            } elseif (is_string($configItem['items'])) {
                $this->assertStringContainsString('@',$configItem['items']);
            }
        }

    }
}

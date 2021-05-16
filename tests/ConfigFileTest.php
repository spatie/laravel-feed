<?php


namespace Spatie\Feed\Test;


class ConfigFileTest extends TestCase
{
    /** @test */
    public function ensure_that_the_items_key_in_the_config_is_array()
    {
        $configItems = config('feed.feeds');

        foreach ($configItems as $configItem) {
            $this->assertIsArray($configItem['items']);
            $this->assertArrayHasKey(1,$configItem['items']);
        }
        
    }
}

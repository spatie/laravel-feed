<?php

namespace Spatie\Feed\Helpers;

use Spatie\Feed\Exceptions\InvalidConfiguration;

class ConfigurationValidator
{
    public static function validate(): void
    {
        if (! is_array(config('feeds.main.format')) && ! str_contains(config('feeds.main.items'), '@')) {
            throw InvalidConfiguration::invalidItemsValue();
        }

        if (! in_array(config('feeds.main.format'), ['atom', 'json', 'rss'])) {
            throw InvalidConfiguration::unrecognizedFormat(config('feeds.main.format'));
        }
    }
}

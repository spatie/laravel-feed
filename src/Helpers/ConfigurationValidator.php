<?php

namespace Spatie\Feed\Helpers;

use Illuminate\Support\Facades\View;
use Spatie\Feed\Exceptions\InvalidConfiguration;

class ConfigurationValidator
{
    public static function validate(?array $feeds = null): void
    {
        $feeds = $feeds ?? (array)config('feed.feeds', []);

        foreach($feeds as $name => $config) {
            if (! in_array($config['format'], ['atom', 'json', 'rss'])) {
                throw InvalidConfiguration::unrecognizedFormat($name, $config['format']);
            }

            if (! is_array($config['items']) && ! str_contains($config['items'], '@')) {
                throw InvalidConfiguration::invalidItemsValue($name);
            }

            if (empty(trim($config['view'])) || ! View::exists($config['view'])) {
                throw InvalidConfiguration::invalidView($name);
            }
        }
    }
}

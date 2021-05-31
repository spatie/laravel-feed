<?php

namespace Spatie\Feed\Helpers;

use Illuminate\Support\Facades\View;
use Spatie\Feed\Exceptions\InvalidConfiguration;

class ConfigurationValidator
{
    public static function validate(?array $feeds = null): void
    {
        $feeds = $feeds ?? (array)config('feed.feeds', []);

        foreach ($feeds as $name => $config) {
            if (! in_array($config['format'], ['atom', 'json', 'rss'])) {
                throw InvalidConfiguration::unrecognizedFormat($name, $config['format']);
            }

            if (! View::exists($config['view'] ?? 'feed::atom')) {
                throw InvalidConfiguration::invalidView($name);
            }
        }
    }

    public static function validateResolver(string $feedName, $resolver): void
    {
        if (! self::feedItemsResolverIsValid($resolver)) {
            throw InvalidConfiguration::invalidItemsValue($feedName);
        }
    }

    protected static function feedItemsResolverIsValid($resolver): bool
    {
        if (! is_string($resolver) && ! is_array($resolver)) {
            return false;
        }

        if (is_string($resolver) && ! str_contains($resolver, '@')) {
            return false;
        }

        if (is_array($resolver) && count($resolver) < 2) {
            return false;
        }

        return true;
    }
}

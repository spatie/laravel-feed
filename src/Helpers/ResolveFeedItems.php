<?php

namespace Spatie\Feed\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ResolveFeedItems
{
    public static function resolve(string $feedName, $resolver): Collection
    {
        ConfigurationValidator::validateResolver($feedName, $resolver);

        $newResolver = $resolver;

        if (is_array($resolver) && ! str_contains($resolver[0], '@')) {
            $newResolver = implode('@', array_slice($resolver, 0, 2));

            if (count($resolver) > 2) {
                $newResolver = array_merge([$newResolver], array_slice($resolver, 2, true));
            }
        }

        return self::callFeedItemsResolver($newResolver);
    }

    protected static function callFeedItemsResolver($resolver): Collection
    {
        $resolver = Arr::wrap($resolver);

        $items = app()->call(
            array_shift($resolver),
            $resolver
        );

        return $items;
    }
}

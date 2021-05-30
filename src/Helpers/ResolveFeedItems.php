<?php

namespace Spatie\Feed\Helpers;

use Illuminate\Support\Collection;

class ResolveFeedItems
{
    public static function resolve(string $feedName, $resolver): Collection
    {
        $newResolver = $resolver;
        $args = [];

        if (is_array($resolver)) {
            if (str_contains($resolver[0], '@')) {
                $newResolver = $resolver[0];
                $args = array_slice($resolver, 1);
            } else {
                $newResolver = "{$resolver[0]}@{$resolver[1]}";
                $args = array_slice($resolver, 2);
            }
        }

        return self::callFeedItemsResolver($newResolver, $args);
    }

    protected static function callFeedItemsResolver($resolver, $args): ?Collection
    {
        return app()->call($resolver, $args);
    }
}

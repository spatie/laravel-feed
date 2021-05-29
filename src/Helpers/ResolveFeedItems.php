<?php

namespace Spatie\Feed\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ResolveFeedItems
{
    public static function resolve(string $feedName, $resolver): Collection
    {
        $newResolver = $resolver;

        if (is_array($resolver) && ! str_contains($resolver[0], '@')) {
            $newResolver = implode('@', array_slice($resolver, 0, 2));

            if (count($resolver) > 2) {
                $newResolver = array_merge([$newResolver], array_slice($resolver, 1));
            }
        }

        return self::callFeedItemsResolver($feedName, $newResolver) ?? collect();
    }

    protected static function callFeedItemsResolver(string $feedName, $resolver): ?Collection
    {
        $ttl = config("feed.feeds.{$feedName}.cache-ttl", 0);

        if ($ttl <= 0 || ! $ttl) {
            return self::callResolver($resolver) ?? collect();
        }

        return Cache::remember("feed:{$feedName}", $ttl, function() use ($resolver) {
            return self::callResolver($resolver);
        });
    }

    protected static function callResolver($resolver): Collection
    {
        $resolver = Arr::wrap($resolver);

        $result = app()->call(
            array_shift($resolver),
            $resolver
        );

        return $result ?? collect();
    }
}

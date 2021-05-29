<?php

namespace Spatie\Feed\Http;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Feed\Feed;

class FeedController
{
    public function __invoke()
    {
        $feeds = config('feed.feeds');

        $name = Str::after(app('router')->currentRouteName(), 'feeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        $items = $this->resolveFeedItems($feed['items']);

        return new Feed(
            $feed['title'],
            $items,
            request()->url(),
            $feed['view'] ?? 'feed::feed',
            $feed['description'] ?? '',
            $feed['language'] ?? '',
            $feed['image'] ?? '',
            $feed['format'] ?? '',
        );
    }

    protected function resolveFeedItems($resolver): Collection
    {
        $newResolver = $resolver;

        if (is_array($resolver) && ! str_contains($resolver[0], '@')) {
            $newResolver = implode('@', array_slice($resolver, 0, 2));

            if (count($resolver) > 2) {
                $newResolver = array_merge([$newResolver], array_slice($resolver, 2));
            }
        }

        return $this->callFeedItemsResolver($newResolver);
    }

    protected function callFeedItemsResolver($resolver): Collection
    {
        $resolver = Arr::wrap($resolver);

        $items = app()->call(
            array_shift($resolver),
            $resolver
        );

        return $items;
    }
}

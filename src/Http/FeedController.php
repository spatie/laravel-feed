<?php

namespace Spatie\Feed\Http;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Feed\Feed;
use Spatie\Feed\ResolveFeedItems;

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
            $feed['language'] ?? ''
        );
    }

    protected function resolveFeedItems($resolver): Collection
    {
        $resolver = Arr::wrap($resolver);

        $items = app()->call(
            array_shift($resolver),
            $resolver
        );

        return $items;
    }
}

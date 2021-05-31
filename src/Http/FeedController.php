<?php

namespace Spatie\Feed\Http;

use Illuminate\Support\Str;
use Spatie\Feed\Feed;
use Spatie\Feed\Helpers\ResolveFeedItems;

class FeedController
{
    public function __invoke()
    {
        $feeds = config('feed.feeds');

        $name = Str::after(app('router')->currentRouteName(), 'feeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        $items = ResolveFeedItems::resolve($name, $feed['items']);

        return new Feed(
            $feed['title'],
            $items,
            request()->url(),
            $feed['view'] ?? 'feed::atom',
            $feed['description'] ?? '',
            $feed['language'] ?? 'en-US',
            $feed['image'] ?? '',
            $feed['format'] ?? 'atom',
        );
    }
}

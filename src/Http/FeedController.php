<?php

namespace Spatie\Feed\Http;

use Spatie\Feed\Feed;

class FeedController
{
    public function __invoke()
    {
        $feeds = config('feed.feeds');

        $name = str_after(app('router')->currentRouteName(), 'feeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        return new Feed($feed['title'], request()->url(), $feed['items']);
    }
}

<?php

namespace Spatie\Feed\Http;

use Spatie\Feed\Feed;
use Illuminate\Support\Str;

class FeedController
{
    public function __invoke()
    {
        $feeds = config('feed.feeds');

        $name = Str::after(app('router')->currentRouteName(), 'feeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        return new Feed($feed['title'], request()->url(), $feed['items'], $feed['view'] ?? 'feed::feed');
    }
}

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
            $feed['description'] ?? ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tincidunt quam in sem accumsan, vel lobortis justo efficitur. Cras dapibus magna a ipsum laoreet pretium. Donec et fringilla magna, id commodo velit. Nunc luctus, turpis a maximus porttitor, elit mauris placerat enim, vel vulputate ipsum lorem nec ligula. Fusce quis blandit nibh. Vivamus ac interdum sem. Vestibulum odio lorem, consequat at tempor a, facilisis congue tellus. Mauris sit amet turpis tellus. ',
            $feed['language'] ?? 'en-US',
            $feed['image'] ?? '',
            $feed['format'] ?? 'atom',
            $feed['xsl'] ?? '',
        );
    }
}

<?php

namespace Spatie\Feed;

use Illuminate\Support\Arr;

class ResolveFeedItems
{
    public function __invoke($resolver)
    {
        $resolver = Arr::wrap($resolver);

        $items = app()->call(
            array_shift($resolver),
            $resolver
        );

        return collect($items)->map(fn (Feedable $feedable) => $this->castToFeedItem($feedable));
    }
}

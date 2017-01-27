<?php

namespace Spatie\Feed\Http;

use Spatie\Feed\Feed;
use Illuminate\Routing\Controller;

class FeedController extends Controller
{
    public function feed()
    {
        $configuration = $this->getFeedConfiguration();

        // Overwrite the relative feed url with the request's absolute url
        $configuration['url'] = request()->url();

        return (new Feed($configuration))->getFeedResponse();
    }

    protected function getFeedConfiguration(): array
    {
        $feeds = config('laravel-feed.feeds');

        $feedIndex = (int) str_replace('spatieLaravelFeed', '', app('router')->currentRouteName());

        return $feeds[$feedIndex] ?? abort(404);
    }
}

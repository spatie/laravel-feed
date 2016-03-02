<?php

namespace Spatie\Feed;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class Feed
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function feed($feed) : HttpResponse
    {
        $data = [];
        $items = explode('@', $feed['items']);
        $method = $items[1];

        $data['items'] = $this->app->make($items[0])->$method()->map(function (FeedItem $item) {
            return $item->getFeedData();
        });

        $data['meta'] = [
            'link' => $feed['url'],
            'description' => $feed['description'],
            'title' => $feed['title'],
            'updated' => collect($data['items'])->sortBy('updated')->last()['updated']->format('Y-m-d H:i:s'),
        ];

        return Response::view(
            'laravel-feed::feed',
            $data, 200,
            ['Content-Type' => 'application/atom+xml; chartset=UTF-8']
        );
    }
}

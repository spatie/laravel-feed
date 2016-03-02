<?php

namespace Spatie\Feed;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidConfiguration;

class Feed
{
    public function getViewResponse(array $feedConfiguration) : HttpResponse
    {
        $feedContent = $this->getFeedContent($feedConfiguration);

        return response($feedContent, 200, ['Content-Type' => 'application/atom+xml; chartset=UTF-8']);
    }

    public function getFeedContent(array $feedConfiguration) : string
    {
        if (!str_contains($feedConfiguration['items'], '@')) {
            throw InvalidConfiguration::delimiterNotPresent($feedConfiguration['items']);
        }

        list($class, $method) = explode('@', $feedConfiguration['items']);

        $items = app($class)->$method();

        $meta = [
            'link' => $feedConfiguration['url'],
            'description' => $feedConfiguration['description'],
            'title' => $feedConfiguration['title'],
            'updated' => $this->getLastUpdatedDate($items, 'Y-m-d H:i:s'),
        ];

        return view('laravel-feed::feed', compact('meta', 'items'))->render();
    }

    protected function getLastUpdatedDate(Collection $items, string $format) : string
    {
        $lastItem = $items
            ->sortBy(function (FeedItem $feedItem) {
                return  $feedItem->getFeedItemUpdated()->format('YmdHis');
            })
            ->last();

        return $lastItem->getFeedItemUpdated()->format($format);
    }
}

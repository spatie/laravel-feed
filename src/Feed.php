<?php

namespace Spatie\Feed;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class Feed implements Responsable
{
    protected string $title;

    protected string $description;

    protected string $language;

    protected string $url;

    protected string $view;

    protected Collection $feedItems;

    public function __construct(
        string $title,
        Collection $items,
        string $url = '',
        string $view = 'feed::feed',
        string $description = '',
        string $language = ''
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->language = $language;
        $this->url = $url ?? request()->url();
        $this->view = $view;

        $this->feedItems = $items->map(fn ($feedable) => $this->castToFeedItem($feedable));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $meta = [
            'id' => url($this->url),
            'link' => url($this->url),
            'title' => $this->title,
            'description' => $this->description,
            'language' => $this->language,
            'updated' => $this->lastUpdated(),
        ];

        if ($this->view === 'feed::json') {
            return $this->toJson();
        }

        $contents = view($this->view, [
            'meta' => $meta,
            'items' => $this->feedItems,
        ]);

        return new Response($contents, 200, [
            'Content-Type' => 'application/xml;charset=UTF-8',
        ]);
    }

    public function toJson(): JsonResponse
    {
        $meta = [
            'version' => 'https://jsonfeed.org/version/1.1',
            'home_page_url' => url(''),
            'feed_url' => url($this->url),
            'title' => $this->title,
            'description' => $this->description,
            'language' => $this->language,
        ];

        $authors = [
            [
                'name' => $this->feedItems->first()->author,
            ],
        ];

        $response = array_merge($meta, [
            'authors' => $authors,
            'items' => $this->feedItems->map(fn ($item) => $item->toJson()),
        ]);

        return new JsonResponse($response, 200);
    }

    protected function castToFeedItem($feedable): FeedItem
    {
        if (is_array($feedable)) {
            $feedable = new FeedItem($feedable);
        }

        if ($feedable instanceof FeedItem) {
            $feedable->validate();

            return $feedable;
        }

        if (! $feedable instanceof Feedable) {
            throw InvalidFeedItem::notFeedable($feedable);
        }

        $feedItem = $feedable->toFeedItem();

        if (! $feedItem instanceof FeedItem) {
            throw InvalidFeedItem::notAFeedItem($feedItem);
        }

        $feedItem->validate();

        return $feedItem;
    }

    protected function lastUpdated(): string
    {
        if ($this->feedItems->isEmpty()) {
            return '';
        }

        return $this->feedItems->sortBy(function ($feedItem) {
            return $feedItem->updated;
        })->last()->updated->toRfc3339String();
    }
}

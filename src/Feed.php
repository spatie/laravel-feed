<?php

namespace Spatie\Feed;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidFeedItem;
use Spatie\Feed\Helpers\FeedContentType;

class Feed implements Responsable
{
    protected string $title;

    protected string $description;

    protected string $language;

    protected string $url;

    protected string $view;

    protected string $image;

    protected string $format;

    protected Collection $feedItems;

    public function __construct(
        string $title,
        Collection $items,
        string $url = '',
        string $view = 'feed::feed',
        string $description = '',
        string $language = '',
        string $image = '',
        string $format = 'atom'
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->language = $language;
        $this->url = $url ?? request()->url();
        $this->view = $view;
        $this->image = $image;
        $this->format = $format;

        $this->feedItems = $items->map(fn ($feedable) => $this->castToFeedItem($feedable));
    }

    public function toResponse($request): Response
    {
        $meta = [
            'id' => url($this->url),
            'link' => url($this->url),
            'title' => $this->title,
            'image' => $this->image,
            'description' => $this->description,
            'language' => $this->language,
            'updated' => $this->lastUpdated(),
        ];

        $contents = view($this->view, [
            'meta' => $meta,
            'items' => $this->feedItems,
        ]);

        return new Response($contents, 200, [
            'Content-Type' => FeedContentType::forResponse($this->format) . ';charset=UTF-8',
        ]);
    }

    public function format(): string
    {
        return $this->format;
    }

    protected function castToFeedItem($feedable): FeedItem
    {
        if (is_array($feedable)) {
            $feedable = new FeedItem($feedable);
        }

        if ($feedable instanceof FeedItem) {
            $feedable->feed = $this;

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

        $feedItem->feed = $this;

        $feedItem->validate();

        return $feedItem;
    }

    protected function lastUpdated(): string
    {
        if ($this->feedItems->isEmpty()) {
            return '';
        }

        $updatedAt = $this->feedItems->sortBy(function ($feedItem) {
            return $feedItem->updated;
        })->last()->updated;

        if ($this->format === 'rss') {
            return $updatedAt->toRssString();
        }

        return $updatedAt->toRfc3339String();
    }

}

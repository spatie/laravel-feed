<?php

namespace Spatie\Feed;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidFeedItem;
use Spatie\Feed\Helpers\FeedContentType;

class Feed implements Responsable
{
    protected Collection $feedItems;

    public function __construct(
        protected string $title,
        protected Collection $items,
        protected string $url = '',
        protected string $view = 'feed::atom',
        protected string $description = '',
        protected string $language = '',
        protected string $image = '',
        protected string $format = 'atom'
    ) {
        $this->url = $url ?? request()->url();

        $this->feedItems = $this->items->map(fn ($feedable) => $this->castToFeedItem($feedable));
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

    protected function castToFeedItem(array | FeedItem | Feedable $feedable): FeedItem
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

        $updatedAt = $this->feedItems
            ->sortBy(fn ($feedItem) => $feedItem->updated)
            ->last()->updated;


        return $this->format === 'rss'
            ? $updatedAt->toRssString()
            : $updatedAt->toRfc3339String();
    }
}

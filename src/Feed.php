<?php

namespace Spatie\Feed;

use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidFeedItem;
use Illuminate\Contracts\Support\Responsable;

class Feed implements Responsable
{
    const SORT_KEY_UPDATED = 'updated';

    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var string */
    protected $view;

    /** @var \Illuminate\Support\Collection */
    protected $items;
    /** @var string */
    private $sortKey;

    public function __construct($title, $url, $resolver, $view, string $sortKey = self::SORT_KEY_UPDATED)
    {
        $this->title = $title;
        $this->url = $url;
        $this->view = $view;
        $this->sortKey = $sortKey;

        $this->items = $this->resolveItems($resolver);
    }

    public function toResponse($request): Response
    {
        $meta = [
            'id' => url($this->url),
            'link' => url($this->url),
            'title' => $this->title,
            'updated' => $this->lastUpdated(),
        ];

        $contents = view($this->view, [
            'meta' => $meta,
            'items' => $this->sortItemsDescBy($this->sortKey),
        ]);

        return new Response($contents, 200, [
            'Content-Type' => 'application/xml;charset=UTF-8',
        ]);
    }

    protected function resolveItems($resolver): Collection
    {
        $resolver = Arr::wrap($resolver);

        $items = app()->call(
            array_shift($resolver), $resolver
        );

        return collect($items)->map(function ($feedable) {
            return $this->castToFeedItem($feedable);
        });
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

    protected function sortItemsDescBy(string $sortKey): Collection
    {
        return $this->items->sortByDesc(function (FeedItem $feedItem) use ($sortKey) {
            return $feedItem->$sortKey;
        });
    }

    protected function lastUpdated(): string
    {
        if ($this->items->isEmpty()) {
            return '';
        }

        return $this->sortItemsDescBy(self::SORT_KEY_UPDATED)->first()->updated->toAtomString();
    }
}

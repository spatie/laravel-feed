<?php

namespace Spatie\Feed;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class Feed implements Responsable
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var string */
    protected $language;

    /** @var string */
    protected $url;

    /** @var string */
    protected $view;

    /** @var \Illuminate\Support\Collection */
    protected $feedItems;

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

        $this->feedItems = $items->map(function ($feedable) {
            return $this->castToFeedItem($feedable);
        });
    }

    public function toResponse($request): Response
    {
        $meta = [
            'id' => url($this->url),
            'link' => url($this->url),
            'title' => $this->title,
            'description' => $this->description,
            'language' => $this->language,
            'updated' => $this->lastUpdated(),
        ];

        $contents = view($this->view, [
            'meta' => $meta,
            'items' => $this->feedItems,
        ]);

        return new Response($contents, 200, [
            'Content-Type' => 'application/xml;charset=UTF-8',
        ]);
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
        })->last()->updated->toRssString();
    }
}

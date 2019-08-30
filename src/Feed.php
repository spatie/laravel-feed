<?php

namespace Spatie\Feed;

use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidFeedItem;
use Illuminate\Contracts\Support\Responsable;

class Feed implements Responsable
{
    /** @var string */
    protected $name;

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
    protected $items;

    public function __construct($name, $title, $url, $resolver, $view, $description, $language)
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->language = $language;
        $this->url = $url;
        $this->view = $view;

        $this->items = $this->resolveItems($resolver);
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
            'items' => $this->items,
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
            $feedable->validate($this->name);

            return $feedable;
        }

        if (! $feedable instanceof Feedable) {
            throw InvalidFeedItem::notFeedable($feedable);
        }

        $feedItem = $feedable->toFeedItem();

        if (! $feedItem instanceof FeedItem) {
            throw InvalidFeedItem::notAFeedItem($feedItem);
        }

        $feedItem->validate($this->name);

        return $feedItem;
    }

    protected function lastUpdated(): string
    {
        if ($this->items->isEmpty()) {
            return '';
        }

        return $this->items->sortBy(function ($feedItem) {
            return $feedItem->updated;
        })->last()->updated->toRssString();
    }
}

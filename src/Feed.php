<?php

namespace Spatie\Feed;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidConfiguration;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class Feed implements Responsable
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var \Illuminate\Support\Collection */
    protected $items;

    public function __construct($title, $url, $resolver)
    {
        $this->title = $title;
        $this->url = $url;

        $this->items = $this->resolveItems($resolver);
    }

    public function toResponse($request)
    {
        $meta = [
            'id' => url($this->url),
            'link' => url($this->url),
            'title' => $this->title,
            'updated' => $this->lastUpdated(),
        ];

        $contents = view('feed::feed', [
            'meta' => $meta,
            'items' => $this->items,
        ]);

        return new Response($contents, 200, [
            'Content-Type' => 'application/xml;charset=UTF-8',
        ]);
    }

    protected function resolveItems($resolver)
    {
        $resolver = array_wrap($resolver);

        $items = app()->call(
            array_shift($resolver), $resolver
        );

        return collect($items)->map(function ($feedable) {
            return $this->castToFeedItem($feedable);
        });
    }

    protected function castToFeedItem($feedable)
    {
        if (! $feedable instanceof Feedable) {
            throw InvalidFeedItem::notFeedable($feedable);
        }

        $feedItem = $feedable->toFeedItem();

        if (is_array($feedItem)) {
            $feedItem = new FeedItem($feedItem);
        }

        if (! $feedItem instanceof FeedItem) {
            throw InvalidFeedItem::notAFeedItem($feedItem);
        }

        $feedItem->validate();

        return $feedItem;
    }

    protected function lastUpdated()
    {
        if (! count($this->items)) {
            return '';
        }

        return $this->items->sortBy('updated')->last()->updated->toAtomString();
    }
}

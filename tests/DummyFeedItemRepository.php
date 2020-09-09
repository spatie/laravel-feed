<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\FeedItem;
use Illuminate\Support\Collection;

class DummyFeedItemRepository
{
    /** @var \Illuminate\Support\Collection */
    public $items;

    public function __construct()
    {
        $this->items = collect([
            new FeedItem([
                'id' => 1,
                'title' => 'feedItemTitle',
                'summary' => 'feedItemSummary',
                'enclosure' => 'http://localhost/image1.jpg',
                'enclosureLength' => 31300,
                'enclosureType' => 'image/jpeg',
                'updated' => Carbon::now(),
                'link' => 'https://localhost/news/testItem1',
                'author' => 'feedItemAuthor',
                'category' => 'feedItemCategory',
            ]),
            new FeedItem([
                'id' => 1,
                'title' => 'feedItemTitle',
                'summary' => 'feedItemSummary',
                'enclosure' => 'http://localhost/image1.jpg',
                'enclosureLength' => 31300,
                'enclosureType' => 'image/jpeg',
                'updated' => Carbon::now(),
                'link' => 'https://localhost/news/testItem1',
                'author' => 'feedItemAuthor',
                'category' => 'feedItemCategory',
            ])
        ]);
    }

    public function getAll(): Collection
    {
        return $this->items;
    }
}

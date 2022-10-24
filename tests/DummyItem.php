<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class DummyItem implements Feedable
{
    public function __construct(public int $id = 1)
    {
    }

    public function toFeedItem(): FeedItem
    {
        return new FeedItem([
            'id' => $this->id,
            'title' => 'feed<>]]>Item"Title"',
            'summary' => 'feedItemSummary',
            'enclosure' => 'http://localhost/image1.jpg',
            'enclosureLength' => 31300,
            'enclosureType' => 'image/jpeg',
            'updated' => Carbon::now()->subMinutes($this->id),
            'link' => 'https://localhost/news/testItem' . $this->id,
            'authorName' => 'feedItemAuthor',
            'authorEmail' => 'feedItemAuthor@test.test',
            'category' => 'feedItemCategory',
        ]);
    }
}

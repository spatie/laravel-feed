<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class DummyItem implements Feedable
{
    public $id = 1;

    public function __construct(int $id = 1)
    {
        $this->id = $id;
    }

    public function toFeedItem(): FeedItem
    {
        return new FeedItem([
            'id' => $this->id,
            'title' => 'feedItemTitle',
            'summary' => 'feedItemSummary',
            'enclosure' => 'http://localhost/image1.jpg',
            'enclosureLength' => 31300,
            'enclosureType' => 'image/jpeg',
            'updated' => Carbon::now()->subMinutes($this->id),
            'link' => 'https://localhost/news/testItem' . $this->id,
            'author' => 'feedItemAuthor@test.test',
            'category' => 'feedItemCategory',
        ]);
    }
}

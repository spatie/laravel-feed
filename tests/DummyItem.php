<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\FeedItem;
use Spatie\Feed\Feedable;

class DummyItem implements Feedable
{
    public function toFeedItem()
    {
        return new FeedItem([
            'id' => 1,
            'title' => 'feedItemTitle',
            'summary' => 'feedItemSummary',
            'updated' => Carbon::now(),
            'link' => 'https://localhost/news/testItem1',
            'author' => 'feedItemAuthor',
        ]);
    }
}

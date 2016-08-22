<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\FeedItem;

class DummyItem implements FeedItem
{
    public function getFeedItemId()
    {
        return 1;
    }

    public function getFeedItemTitle() : string
    {
        return 'feedItemTitle';
    }

    public function getFeedItemSummary() : string
    {
        return 'feedItemSummary';
    }

    public function getFeedItemUpdated() : Carbon
    {
        return Carbon::now();
    }

    public function getFeedItemLink() : string
    {
        return 'https://localhost/news/testItem1';
    }

    public function getFeedItemAuthor() : string
    {
        return 'feedItemAuthor';
    }
}

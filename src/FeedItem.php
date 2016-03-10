<?php

namespace Spatie\Feed;

use Carbon\Carbon;

interface FeedItem
{
    public function getFeedItemId();

    public function getFeedItemTitle() : string;

    public function getFeedItemUpdated() : Carbon;

    public function getFeedItemSummary() : string;

    public function getFeedItemLink() : string;

    public function getFeedItemAuthor() : string;
}

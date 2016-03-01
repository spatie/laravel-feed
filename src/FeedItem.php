<?php

namespace Spatie\Feed;

use Carbon\Carbon;

interface FeedItem
{
    public function getFeedData() : array;

    public function getFeedItemTitle() : string;

    public function getFeedItemId();

    public function getFeedItemUpdated() : Carbon;

    public function getFeedItemSummary() : string;

    public function getFeedItemLink() : string;
}

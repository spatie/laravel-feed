<?php

namespace Spatie\Feed;

use Carbon\Carbon;

interface FeedItem
{
    public function getFeedData() : array;

    public function getUpdated() : Carbon;

    public function getFeedItemTitle() : string;

    public function getFeedItemId();

    public function getFeedItemUpdated() : Carbon;

    public function getFeedItemSummary() : string;

    public function getFeedItemLink() : string;
}

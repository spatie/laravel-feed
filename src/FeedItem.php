<?php

namespace Spatie\Feed;

use Carbon\Carbon;

interface FeedItem
{
    public function getFeedData() : array;

    public function getTitleForFeedItem() : string;

    public function getIdForFeedItem();

    public function getUpdatedForFeedItem() : Carbon;

    public function getSummaryForFeedItem() : string;

    public function getLinkForFeedItem() : string;
}
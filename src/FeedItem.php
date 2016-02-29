<?php

namespace Spatie\Feed;

interface FeedItem
{
    public function getFeedData() : array;
}
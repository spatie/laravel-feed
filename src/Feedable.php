<?php

namespace Spatie\Feed;

interface Feedable
{
    public function toFeedItem(): FeedItem;
}

<?php

namespace Spatie\Feed;

interface Feedable
{
    /**
     * @return \Spatie\Feed\FeedItem
     */
    public function toFeedItem();
}

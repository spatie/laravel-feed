<?php

namespace Spatie\Feed;

interface Feedable
{
    /**
     * @return array|\Spatie\Feed\FeedItem
     */
    public function toFeedItem();
}

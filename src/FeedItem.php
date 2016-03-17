<?php

namespace Spatie\Feed;

interface FeedItem
{
    public function getFeedItemId();

    public function getFeedItemTitle();

    public function getFeedItemUpdated();

    public function getFeedItemSummary();

    public function getFeedItemLink();

    public function getFeedItemAuthor();
}

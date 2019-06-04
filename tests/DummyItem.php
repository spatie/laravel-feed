<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class DummyItem implements Feedable
{
    /** @var int */
    private $id;
    /** @var Carbon */
    private $updated;

    public function __construct(int $id, Carbon $updated)
    {
        $this->id = $id;
        $this->updated = $updated;
    }

    public function toFeedItem()
    {
        return new FeedItem([
            'id' => $this->id,
            'title' => 'feedItemTitle',
            'summary' => 'feedItemSummary',
            'updated' => $this->updated,
            'link' => 'https://localhost/news/testItem1',
            'author' => 'feedItemAuthor',
        ]);
    }
}

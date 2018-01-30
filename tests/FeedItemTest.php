<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\FeedItem;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class FeedItemTest extends TestCase
{
    /** @test */
    public function a_feed_is_invalid_if_a_field_is_missing()
    {
        $this->expectException(InvalidFeedItem::class);

        FeedItem::create()->validate();
    }
}

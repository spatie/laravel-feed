<?php

namespace Spatie\Feed\Test;

use ArrayAccess;
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

    /** @test */
    public function a_feed_item_implements_array_access()
    {
        $item = FeedItem::create()
            ->title('The Title');

        $this->assertTrue($item instanceof ArrayAccess);

        $this->assertEquals($item['title'], 'The Title');

        $item['title'] = 'A New Title';

        $this->assertEquals($item['title'], 'A New Title');

        $this->assertFalse(isset($item['rubbish']));
        $this->assertTrue(isset($item['title']));
    }
}

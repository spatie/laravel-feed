<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\Exceptions\InvalidFeedItem;
use Spatie\Feed\FeedItem;

class FeedItemTest extends TestCase
{
    /** @test */
    public function a_feed_is_invalid_if_a_field_is_missing()
    {
        $this->expectException(InvalidFeedItem::class);

        FeedItem::create()->validate();
    }

    /** @test * */
    public function it_can_be_created_without_errors()
    {
        FeedItem::create()
            ->title('A title')
            ->category('a category')
            ->link('https://spatie.be')
            ->authorName('an author')
            ->authorEmail('author@test.test')
            ->updated(now());

        $this->expectNotToPerformAssertions();
    }
}

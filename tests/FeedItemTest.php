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

    /** @test */
    public function it_can_add_values_conditionally()
    {
        $item = FeedItem::create([
            'authorName' => 'pretty ok author name',
            'link' => 'https://spatie.be',
        ])
            ->title('A title')
            ->when(true, fn(FeedItem $item) => $item->category('very good category'))
            ->when(false, fn(FeedItem $item) => $item->authorName('very bad name'))
            ->unless(false, fn(FeedItem $item) => $item->authorEmail('please-no-spam@example.com'))
            ->unless(true, fn(FeedItem $item) => $item->link('https://badlink.com'));

        $this->assertSame('A title', $item->title);
        $this->assertSame(['very good category'], $item->category);
        $this->assertSame('pretty ok author name', $item->authorName);
        $this->assertSame('please-no-spam@example.com', $item->authorEmail);
        $this->assertSame('https://spatie.be', $item->link);
    }
}

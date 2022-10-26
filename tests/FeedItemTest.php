<?php

use Spatie\Feed\Exceptions\InvalidFeedItem;
use Spatie\Feed\FeedItem;

test('a feed is invalid if a field is missing', function () {
    FeedItem::create()->validate();
})->throws(InvalidFeedItem::class);

it('can be created without errors', function () {
    FeedItem::create()
        ->title('A title')
        ->category('a category')
        ->link('https://spatie.be')
        ->authorName('an author')
        ->authorEmail('author@test.test')
        ->updated(now());

    $this->expectNotToPerformAssertions();
});

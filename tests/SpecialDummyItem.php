<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class SpecialDummyItem implements Feedable
{
    public function toFeedItem()
    {
        return new FeedItem([
            'id' => 1,
            'title' => 'This is &, ∑´†®¥¨˙©ƒ∂˙∆∂ß∑ƒ©˙ú',
            'summary' => 'The summary contains a CEnd tag, ]]>, but it is escaped properly',
            'updated' => Carbon::now(),
            'link' => 'https://localhost/news/testItem1',
            'author' => 'feedItemAuthor',
        ]);
    }
}

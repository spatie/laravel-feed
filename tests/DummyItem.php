<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\FeedItem;
use Carbon\Carbon;

class DummyItem implements FeedItem
{
    public function getFeedData() : array
    {
        return [
            'title' => $this->getFeedItemTitle(),
            'id' => $this->getFeedItemId(),
            'updated' => $this->getFeedItemUpdated(),
            'summary' => $this->getFeedItemSummary(),
            'link' => $this->getFeedItemLink(),
        ];
    }

    public function getUpdated() : Carbon
    {
        return Carbon::create('2016', '02', '29', '16', '06', '18');
    }

    public function getFeedItemId()
    {
        return 1;
    }

    public function getFeedItemTitle() : string
    {
        return 'Ducimus ipsum consequatur vel libero debitis quis voluptatem.';
    }

    public function getFeedItemSummary() : string
    {
        return 'Officia aliquid rem repudiandae ut sed voluptatem non. Fuga libero omnis atque quam error. Iure dolorum labore ducimus temporibus.';
    }

    public function getFeedItemUpdated() : Carbon
    {
        return Carbon::create('2016', '02', '29', '16', '06', '18');
    }

    public function getFeedItemLink() : string
    {
        return 'http://localhost/news/ducimus-ipsum-consequatur-vel-libero-debitis-quis-voluptatem';
    }
}

<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\FeedItem;
use Carbon\Carbon;

class DummyItem implements FeedItem
{
    public function getFeedData() : array
    {
        return [
            'title' => $this->getTitleForFeedItem(),
            'id' => $this->getIdForFeedItem(),
            'updated' => $this->getUpdatedForFeedItem(),
            'summary' => $this->getSummaryForFeedItem(),
            'link' => $this->getLinkForFeedItem(),
        ];
    }

    public function getIdForFeedItem()
    {
        return 1;
    }

    public function getTitleForFeedItem() : string
    {
        return 'Ducimus ipsum consequatur vel libero debitis quis voluptatem.';
    }

    public function getSummaryForFeedItem() : string
    {
        return 'Officia aliquid rem repudiandae ut sed voluptatem non. Fuga libero omnis atque quam error. Iure dolorum labore ducimus temporibus.';
    }

    public function getUpdatedForFeedItem() : Carbon
    {
        return Carbon::create('2016','02','15', '11', '23','41');
    }

    public function getLinkForFeedItem() : string
    {
        return 'http://blender.192.168.10.10.xip.io/nl/news/ducimus-ipsum-consequatur-vel-libero-debitis-quis-voluptatem';
    }

}
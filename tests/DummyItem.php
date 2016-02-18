<?php

namespace Spatie\Rss\Test;

use Spatie\Rss\RssItem;

class DummyItem implements RssItem
{
    public function getFeedData() : array
    {
        return [
            'title' => 'Ducimus ipsum consequatur vel libero debitis quis voluptatem.',
            'id' => 1,
            'updated' => '2016-02-15 11:23:41',
            'summary' => 'Officia aliquid rem repudiandae ut sed voluptatem non. Fuga libero omnis atque quam error. Iure dolorum labore ducimus temporibus.',
            'link' => 'http://blender.192.168.10.10.xip.io/nl/news/ducimus-ipsum-consequatur-vel-libero-debitis-quis-voluptatem',
        ];
    }
}

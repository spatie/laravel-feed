<?php

return [

    'feeds' => [
        [
            'items' => '',  // Fill in the class with a method that returns a collection of items that must come in the feed. e.g.: 'App\Repositories\NewsItemRepository@getAllOnline'
            'url'   => '',  // feed url, on which the feeds would be shown

            'meta'  => [
                'link'          => '',
                'title'         => '',
                'updated'       => \Carbon\Carbon::now()->toATOMString(),
                'description'   => '',
            ]

        ],
    ],

];

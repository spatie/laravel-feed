<?php

return [

    'feeds' => [
        [
            /**
             * Fill in for items a class with a method that returns a collection of items that you want in the feed.
             */
            'items' => '',  // e.g.: 'App\Repositories\NewsItemRepository@getAllOnline'
            'url' => '',  // here goes a feed url, on which the feeds will be shown.
            'title' => 'This is feed 1 from the unit tests',
            'description' => 'This is feed 1 from the unit tests.',
            'updated' => \Carbon\Carbon::now()->toAtomString()

        ],
    ],

];

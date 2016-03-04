<?php

return [

    'feeds' => [
        [
            /*
             * Here you can specify which class and method will return the items
             * that should appear in the feed. For example:
             * 'App\Repositories\NewsItemRepository@getAllOnline'
             */
            'items' => '',

            /*
             * The feed will be available on this url
             * If url is left empty it will do nothing
             */
            'url' => '',

            'title' => 'My feed',

            'description' => 'Description of my feed',
        ],
    ],

];

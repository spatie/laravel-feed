<?php

return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => '',

            /*
             * The feed will be available on this url.
             */
            'url' => '',

            'title' => 'My feed',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::feed',

            /*
             * The model field that the feed should be sorted bys
             */
            'sort_by' => 'updated',
        ],
    ],
];

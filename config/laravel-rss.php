<?php

return [

    'feeds' => [
        [
            'items' => 'App\Repositories\NewsItemRepository@getAllOnline',

            'url'   => '/en/myfeed',
            'meta'  => [
                'link'          => "http://blender.192.168.10.10.xip.io/en/feed",
                'title'         => 'News en',
                'updated'       => \Carbon\Carbon::now()->toATOMString(),
                'description'   => '...',
                'irong'         => 'ksngkrgn'
            ]

        ],
        [
            'items' => 'App\Repositories\NewsItemRepository@getAllOnline',

            'url'   => '/nl/myfeed',
            'meta'  => [
                'link'          => "http://blender.192.168.10.10.xip.io/nl/feed",
                'title'         => 'News nl',
                'updated'       => \Carbon\Carbon::now()->toATOMString(),
                'description'   => '...',
                'irong'         => 'ksngkrgn'
            ]
        ],
    ]


];
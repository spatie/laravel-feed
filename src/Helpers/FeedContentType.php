<?php

namespace Spatie\Feed\Helpers;

class FeedContentType
{
    public static function forResponse(string $feedFormat): string
    {
        $typeMap = [
            'atom' => 'application/xml',
            'json' => 'application/json',
            'rss' => 'application/xml',
        ];

        $contentType = config('feed::content-type');
        $mappedType = $typeMap[$feedFormat] ?? 'application/xml';

        return empty($contentType)
            ? $mappedType
            : $contentType;
    }

    public static function forLink(string $feedFormat): string
    {
        $typeMap = [
            'atom' => 'application/rss+xml',
            'json' => 'application/feed+json',
            'rss' => 'application/atom+xml',
        ];

        $type = config('feed::type');
        $mappedType = $typeMap[$feedFormat] ?? 'application/atom+xml';

        return empty($type)
            ? $mappedType
            : $type;
    }

}

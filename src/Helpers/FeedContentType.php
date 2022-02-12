<?php

namespace Spatie\Feed\Helpers;

class FeedContentType
{
    public static array $typeMap = [
        'atom' => ['response' => 'application/xml', 'link' => 'application/atom+xml'],
        'json' => ['response' => 'application/json', 'link' => 'application/feed+json'],
        'rss' => ['response' => 'application/xml', 'link' => 'application/rss+xml'],
    ];

    public static array $defaults = [
        'response' => 'application/xml',
        'link' => 'application/atom+xml',
    ];

    public static function forResponse(string $feedName, string $feedFormat): string
    {
        $contentType = config('feed.feeds.' . $feedName . '.contentType');
        $mappedType = self::$typeMap[$feedFormat]['response'] ?? self::$defaults['response'];

        return empty($contentType)
            ? $mappedType
            : $contentType;
    }

    public static function forLink(string $feedName, string $feedFormat): string
    {
        $type = config('feed.feeds.' . $feedName . '.type');
        $mappedType = self::$typeMap[$feedFormat]['link'] ?? self::$defaults['link'];

        return empty($type)
            ? $mappedType
            : $type;
    }
}

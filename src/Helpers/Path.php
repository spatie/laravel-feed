<?php

namespace Spatie\Feed\Helpers;

class Path
{
    public static function merge(...$paths): string
    {
        return collect($paths)->map(function (string $path) {
            return trim($path, '/');
        })->implode('/');
    }
}

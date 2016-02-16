<?php

namespace Spatie\LaravelRss;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Skeleton\SkeletonClass
 */
class RssFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'rss';
    }
}

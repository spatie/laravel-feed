<?php

namespace Spatie\Feed\Http;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Feed\Exceptions\InvalidConfigFile;
use Spatie\Feed\Feed;
use Spatie\Feed\ResolveFeedItems;

class FeedController
{
    public function __invoke()
    {
        $feeds = config('feed.feeds');

        $name = Str::after(app('router')->currentRouteName(), 'feeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        $items = $this->resolveCallableFeedItems($feed['items']);

        return new Feed(
            $feed['title'],
            $items,
            request()->url(),
            $feed['view'] ?? 'feed::feed',
            $feed['description'] ?? '',
            $feed['language'] ?? ''
        );
    }

    protected function resolveFeedItems(string $callable,$arg = null): Collection
    {
        return app()->call($callable, $arg);
    }

    protected function resolveCallableFeedItems($resolver): Collection
    {
        $arg = [];
        if (is_array($resolver)) {

            //if items is like ['App\Model@getAllFeedItems', 'argument']
            if (strpos($resolver[0],'@')){

                $arg = Arr::wrap($resolver[1]);
            }else{
                //The Feed Class(Model)
                $feedClass = $resolver[0];

                //The Feed Method inisde the calss(model)
                $feedClassMethod = $resolver[1];
                $resolver = $this->genrateCallableString($feedClass,$feedClassMethod);

                //Argument to be passed
                $arg = isset($resolver[2]) ? Arr::wrap($resolver[2]) : [];
            }

        } elseif (!strpos($resolver,'@')) {

            throw InvalidConfigFile::itemsIsNotFilled($resolver);
        }
        return $this->resolveFeedItems($resolver,$arg);
    }

    protected function genrateCallableString(string $class , string $method) :string
    {
        return $class . '@' . $method;
    }
}

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

        if (!is_array($feed['items'])) {
            throw InvalidConfigFile::itemsIsNotArray($feed['items'],gettype($feed['items']));
        }

        if (count($feed['items']) < 2) {
            throw InvalidConfigFile::itemsIsNotFilled($feed['items']);
        }

        $items = $this->resolveFeedItems($feed['items']);

        return new Feed(
            $feed['title'],
            $items,
            request()->url(),
            $feed['view'] ?? 'feed::feed',
            $feed['description'] ?? '',
            $feed['language'] ?? ''
        );
    }

    protected function resolveFeedItems(array $resolver): Collection
    {
        //The Feed Class(Model)
        $feedClass = $resolver[0];

        //The Feed Method inisde the calss(model)
        $feedClassMethod = $resolver[1];

        //Argument to be passed
        $arg = isset($resolver[2]) ? Arr::wrap($resolver[2]) : [];

        $items = app()->call(
            $this->genrateCallableString($feedClass,$feedClassMethod),
            $arg
        );

        return $items;
    }

    protected function genrateCallableString(string $class , string $method) :string
    {
        return $class . '@' . $method;
    }
}

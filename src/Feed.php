<?php

namespace Spatie\Feed;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Spatie\Feed\Exceptions\InvalidConfiguration;
class Feed
{
    /** @var array */
    protected $feedConfiguration;
    public function __construct(array $feedConfiguration)
    {
        $this->feedConfiguration = $feedConfiguration;
        if (!str_contains($feedConfiguration['items'], '@')) {
            throw InvalidConfiguration::delimiterNotPresent($feedConfiguration['items']);
        }
    }
    public function getFeedResponse()
    {
        return response($this->getFeedContent(), 200, array('Content-Type' => 'application/xml;charset=UTF-8'));
    }
    public function getFeedContent()
    {
        list($class, $method) = explode('@', $this->feedConfiguration['items']);
        $items = app($class)->{$method}();
        $meta = array('id' => url($this->feedConfiguration['url']), 'link' => url($this->feedConfiguration['url']), 'title' => $this->feedConfiguration['title'], 'updated' => $this->getLastUpdatedDate($items));
        return view('laravel-feed::feed', compact('meta', 'items'))->render();
    }
    protected function getLastUpdatedDate(Collection $items)
    {
        if (!count($items)) {
            return '';
        }
        $lastItem = $items->sortBy(function (FeedItem $feedItem) {
            return $feedItem->getFeedItemUpdated()->format('YmdHis');
        })->last();
        return $lastItem->getFeedItemUpdated()->toAtomString();
    }
}
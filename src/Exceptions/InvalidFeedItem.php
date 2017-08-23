<?php

namespace Spatie\Feed\Exceptions;

use Exception;

class InvalidFeedItem extends Exception
{
    /** @var \Spatie\Feed\FeedItem|null */
    protected $subject;

    public static function notFeedable($subject)
    {
        return tap(new static('Object doesn\'t implement `Spatie\Feed\Feedable`'), function ($exception) {
            $exception->subject = $subject;
        });
    }

    public static function notAFeedItem($subject)
    {
        return tap(new static('`toFeedItem` should return an instance of `Spatie\Feed\Feedable`'), function ($exception) {
            $exception->subject = $subject;
        });
    }

    public static function missingField(FeedItem $subject, $field)
    {
        return tap(new static("Field `{$field}` is required"), function ($exception) {
            $exception->subject = $subject;
        });
    }

    public function getFeedItem(): FeedItem
    {
        return $this->subject;
    }
}

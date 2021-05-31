<?php

namespace Spatie\Feed\Exceptions;

use Exception;
use Spatie\Feed\FeedItem;

class InvalidFeedItem extends Exception
{
    public ?FeedItem $subject;

    public static function notFeedable($subject): self
    {
        return (new static('Object does not implement `Spatie\Feed\Feedable`'))->withSubject($subject);
    }

    public static function notAFeedItem($subject): self
    {
        return (new static('`toFeedItem` should return an instance of `Spatie\Feed\Feedable`'))->withSubject($subject);
    }

    public static function missingField(FeedItem $subject, $field): self
    {
        return (new static("Field `{$field}` is required"))->withSubject($subject);
    }

    protected function withSubject($subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}

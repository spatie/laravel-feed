<?php


namespace Spatie\Feed\Exceptions;
use Exception;

class InvalidConfigFile extends Exception
{
    public $subject;

    public static function itemsIsNotArray($subject,$given)
    {
        return (new static('items key should be an array '. $given .' given'))->withSubject($subject);
    }

    public static function itemsIsNotFilled($subject)
    {
        return (new static('items key should have Class name and Method Name,please read README'))->withSubject($subject);
    }

    protected function withSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }
}

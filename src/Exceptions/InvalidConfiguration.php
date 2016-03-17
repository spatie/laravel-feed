<?php

namespace Spatie\Feed\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function delimiterNotPresent($configValue)
    {
        return new static("Could not find delimeter '@' in `{$configValue}`");
    }
}

<?php

namespace Spatie\Feed\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function unrecognizedFormat(string $format): static
    {
        return new static("Unrecognized feed format: '{$format}'.");
    }

    public static function invalidItemsValue(): static
    {
        return new static("Invalid value for feed 'items' configuration key.");
    }
}

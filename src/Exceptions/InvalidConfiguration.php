<?php

namespace Spatie\Feed\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function unrecognizedFormat(string $name, string $format): static
    {
        return new static("Unrecognized format configuration value '{$format}' for feed '{$name}'.");
    }

    public static function invalidItemsValue(string $name): static
    {
        return new static("Invalid 'items' configuration value for feed '{$name}'.");
    }

    public static function invalidView(string $name): static
    {
        return new static("Invalid 'view' value in configuration for feed '{$name}'.");
    }
}

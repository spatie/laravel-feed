<?php

namespace Spatie\Feed;

class Format
{
    public static function escapeCData($value)
    {
        return str_replace(']]>', ']]]]><![CDATA[>', $value);
    }
}

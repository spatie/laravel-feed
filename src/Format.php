<?php

namespace Spatie\Feed;

class Format
{
    /*
    * Escape given sequence to remove ending CDATA tags
    *
    * @param string $value
    * @return string
    */
    public static function escape_cdata($value)
    {
        return str_replace(']]>', ']]]]><![CDATA[>', $value);
    }
}

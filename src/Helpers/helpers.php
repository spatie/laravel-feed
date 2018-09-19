<?php

if (! function_exists('escape_cdata')) {
    /*
    * Escape given sequence to remove ending CDATA tags
    *
    * @param string $value
    * @return string
    */
    function escape_cdata($value)
    {
        return str_replace(']]>', ']]]]><![CDATA[>', $value);
    }
}

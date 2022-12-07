<?php

uses(Spatie\Feed\Test\TestCase::class)->in('.');

if (! function_exists('str')) {
    function str($string)
    {
        return \Illuminate\Support\Str::of($string);
    }
}

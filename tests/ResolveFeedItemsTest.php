<?php

use Spatie\Feed\Helpers\ResolveFeedItems;
use Spatie\Feed\Test\DummyRepository;

test('it resolves a resolver class and method string', function () {
    $result = ResolveFeedItems::resolve('feed1', '\Spatie\Feed\Test\DummyRepository@getAll');

    expect($result)->toHaveCount(5);
});

test('it resolves a resolver class and method string with parameters', function () {
    $result = ResolveFeedItems::resolve('feed1', ['Spatie\Feed\Test\DummyRepository@getAllWithArguments', 'filter' => 'first']);

    expect($result)->toHaveCount(1);
});

test('it resolves a resolver class and method tuple', function () {
    $result = ResolveFeedItems::resolve('feed1', [DummyRepository::class, 'getAll']);

    expect($result)->toHaveCount(5);
});

test('it resolves a resolver class and method tuple with parameters', function () {
    $result = ResolveFeedItems::resolve('feed1', [DummyRepository::class, 'getAllWithArguments', 'filter' => 'first']);

    expect($result)->toHaveCount(1);
});

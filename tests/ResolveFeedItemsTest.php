<?php

use Spatie\Feed\Helpers\ResolveFeedItems;
use Spatie\Feed\Test\DummyRepository;

use function PHPUnit\Framework\assertCount;

test('it resolves a resolver class and method string', function () {
    $result = ResolveFeedItems::resolve('feed1', '\Spatie\Feed\Test\DummyRepository@getAll');

    assertCount(5, $result);
});

test('it resolves a resolver class and method string with parameters', function () {
    $result = ResolveFeedItems::resolve('feed1', ['Spatie\Feed\Test\DummyRepository@getAllWithArguments', 'filter' => 'first']);

    assertCount(1, $result);
});

test('it resolves a resolver class and method tuple', function () {
    $result = ResolveFeedItems::resolve('feed1', [DummyRepository::class, 'getAll']);

    assertCount(5, $result);
});

test('it resolves a resolver class and method tuple with parameters', function () {
    $result = ResolveFeedItems::resolve('feed1', [DummyRepository::class, 'getAllWithArguments', 'filter' => 'first']);

    assertCount(1, $result);
});

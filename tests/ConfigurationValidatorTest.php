<?php

use Spatie\Feed\Exceptions\InvalidConfiguration;
use Spatie\Feed\Helpers\ConfigurationValidator;

test('it validates feed formats', function () {
    $exceptionCounter = 0;
    $formats = ['atom', 'json', 'rss', 'other'];

    foreach ($formats as $format) {
        try {
            ConfigurationValidator::validate([
                'feed1' => [
                    'view' => 'feed::rss',
                    'format' => $format,
                ],
            ]);
        } catch (InvalidConfiguration $e) {
            $exceptionCounter++;
        }
    }

    expect($exceptionCounter)->toBe(1);
});

test('it throws an exception for invalid feed types', function () {
    ConfigurationValidator::validate([
        'feed1' => [
            'view' => 'feed::rss',
            'format' => 'test',
        ],
    ]);
})->throws(InvalidConfiguration::class);

test('it throws an exception for an invalid items value', function () {
    $exceptionCounter = 0;

    $invalidItems = [[], null, '', ['test']];
    $validItems = ['Model@getAll', ['App\\Model', 'getItems'], ['App\\Model', 'getItems', 'param1']];

    $items = array_merge($invalidItems, $validItems);

    foreach ($items as $itemsValue) {
        try {
            ConfigurationValidator::validateResolver('feed1', $itemsValue);
        } catch (InvalidConfiguration $e) {
            $exceptionCounter++;
        }
    }

    expect($invalidItems)->toHaveCount($exceptionCounter);
});

test('it throws an exception for an invalid view', function () {
    $exceptionCounter = 0;
    $views = ['', 'feed::missing', null, 'feed::rss'];

    foreach ($views as $view) {
        try {
            ConfigurationValidator::validate([
                'feed1' => [
                    'view' => $view,
                    'format' => 'json',
                ],
            ]);
        } catch (InvalidConfiguration $e) {
            $exceptionCounter++;
        }
    }

    expect($exceptionCounter)->toBe(2);
});

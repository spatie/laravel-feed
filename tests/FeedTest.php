<?php

use Illuminate\Http\Request;
use Spatie\Feed\Feed;

use function Spatie\Snapshots\assertMatchesSnapshot;

use Spatie\TestTime\TestTime;

beforeEach(function () {
    $this->feedNames = ['feed1', 'feed2', 'feed3', 'feed1.rss', 'feed1.json'];
});

test('all feeds are available on their registered routes', function () {
    collect($this->feedNames)->each(function (string $feedName) {
        $this->get("/feedBaseUrl/{$feedName}")->assertStatus(200);
    });
});

test('all feed items have expected data', function () {
    collect($this->feedNames)->each(function (string $feedName) {
        $generatedFeedContent = $this->get("/feedBaseUrl/{$feedName}")->getContent();

        assertMatchesSnapshot($generatedFeedContent);
    });
});

it('can render all feed links via a view', function () {
    $feedLinksHtml = $this->get('/test-route')->getContent();

    assertMatchesSnapshot($feedLinksHtml);
});

it('can render all feed links via the blade component', function () {
    $feedLinksHtml = trim($this->get('/test-route-blade-component')->getContent());

    assertMatchesSnapshot($feedLinksHtml);
});

test('all feed items can have a custom view', function () {
    $response = $this->get('/feedBaseUrl/feed-with-custom-view');

    $response->assertStatus(200);

    $response->assertViewIs('feed::links');
});

it('can accept an array', function () {
    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $feed = new Feed('title', collect([
        [
            'id' => 1,
            'authorName' => 'John',
            'authorEmail' => 'john@test.test',
            'title' => 'Song A',
            'updated' => now(),
            'summary' => 'summary A',
            'link' => 'link A',
        ],
        [
            'id' => 2,
            'authorName' => 'paul',
            'authorEmail' => 'paul@test.test',
            'title' => 'Song B',
            'updated' => now(),
            'summary' => 'summary B',
            'link' => 'link B',
        ],
    ]));

    $response = $feed->toResponse(Request::capture());

    assertMatchesSnapshot($response->content());
});

it('returns the correct content type', function () {
    $feeds = [
        'feed1' => 'application/xml',
        'feed1.rss' => 'application/xml',
        'feed1.json' => 'application/json',
    ];

    collect($feeds)->each(function (string $contentType, $feedName) {
        $response = $this->get("/feedBaseUrl/{$feedName}");

        $response->assertStatus(200);

        expect(
            (string)(str($response->headers->get('content-type'))->before(';'))
        )->toBe($contentType);
    });
});

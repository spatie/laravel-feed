<?php

namespace Spatie\Feed\Test;

use Spatie\Feed\Helpers\ResolveFeedItems;

class ResolveFeedItemsTest extends TestCase
{
    /** @test */
    public function it_resolves_a_resolver_class_and_method_string()
    {
        $result = ResolveFeedItems::resolve('\Spatie\Feed\Test\DummyRepository@getAll');

        $this->assertCount(5, $result);
    }

    /** @test */
    public function it_resolves_a_resolver_class_and_method_string_with_parameters()
    {
        $result = ResolveFeedItems::resolve(['Spatie\Feed\Test\DummyRepository@getAllWithArguments', 'filter' => 'first']);

        $this->assertCount(1, $result);
    }

    /** @test */
    public function it_resolves_a_resolver_class_and_method_tuple()
    {
        $result = ResolveFeedItems::resolve([DummyRepository::class, 'getAll']);

        $this->assertCount(5, $result);
    }

    /** @test */
    public function it_resolves_a_resolver_class_and_method_tuple_with_parameters()
    {
        $result = ResolveFeedItems::resolve([DummyRepository::class, 'getAllWithArguments', 'filter' => 'first']);

        $this->assertCount(1, $result);
    }
}

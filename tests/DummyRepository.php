<?php

namespace Spatie\Feed\Test;

class DummyRepository
{
    /** @var \Illuminate\Support\Collection */
    public $items;

    public function __construct()
    {
        $this->items = collect([
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
        ]);
    }

    public function getAll()
    {
        return $this->items;
    }

    public function getAllWithArguments(string $filter = '')
    {
        return $filter === 'first'
            ? collect($this->items->first())
            : $this->items;
    }
}

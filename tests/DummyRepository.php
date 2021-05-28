<?php

namespace Spatie\Feed\Test;

use Illuminate\Support\Collection;

class DummyRepository
{
    /** @var \Illuminate\Support\Collection */
    public $items;

    public function __construct()
    {
        $this->items = collect([
            new DummyItem(1),
            new DummyItem(2),
            new DummyItem(3),
            new DummyItem(4),
            new DummyItem(5),
        ]);
    }

    public function getAll(): Collection
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

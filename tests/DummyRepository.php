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
        if (request()->query->getInt('add', 0) === 1) {
            $this->items->push(new DummyItem($this->items->count() + 1));
        }

        return $this->items;
    }

    public function getAllWithArguments(string $filter = '')
    {
        return $filter === 'first'
            ? collect($this->items->first())
            : $this->items;
    }
}

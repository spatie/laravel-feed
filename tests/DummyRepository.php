<?php

namespace Spatie\Feed\Test;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class DummyRepository
{
    /** @var \Illuminate\Support\Collection */
    public $items;

    public function __construct()
    {
        $this->items = collect([
            new DummyItem(1, Carbon::create(2016, 1, 5, 0, 0, 0)->setTimezone('Europe/Brussels')->startOfDay()),
            new DummyItem(2, Carbon::create(2016, 1, 4, 0, 0, 0)->setTimezone('Europe/Brussels')->startOfDay()),
            new DummyItem(3, Carbon::create(2016, 1, 3, 0, 0, 0)->setTimezone('Europe/Brussels')->startOfDay()),
            new DummyItem(4, Carbon::create(2016, 1, 2, 0, 0, 0)->setTimezone('Europe/Brussels')->startOfDay()),
            new DummyItem(5, Carbon::create(2016, 1, 1, 0, 0, 0)->setTimezone('Europe/Brussels')->startOfDay()),
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

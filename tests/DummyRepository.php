<?php

namespace Spatie\Feed\Test;

class DummyRepository
{
    public function getAll()
    {
        return collect([
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
        ]);
    }

    public function getAllWithFilter($filter = '')
    {
        if ($filter != '') {
            return collect([
                new DummyItem(),
            ]);
        }

        return collect([
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
        ]);
    }
}

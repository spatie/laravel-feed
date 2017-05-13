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

    public function getAllWithArguments($filter = '')
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

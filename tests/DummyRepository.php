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
}

<?php

namespace Spatie\Rss\Test;


class DummyRepository
{
    public function getAllOnline(){
        return collect([
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem(),
            new DummyItem()

        ]);
    }

}
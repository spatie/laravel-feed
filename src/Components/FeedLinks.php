<?php

namespace Spatie\Feed\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FeedLinks extends Component
{
    public function render(): View
    {
        return view('feed::links');
    }
}

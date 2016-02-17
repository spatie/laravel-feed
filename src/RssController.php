<?php

namespace Spatie\Rss;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Response;

class RssController extends Controller
{
    protected $app;

    public function __construct(Application $app){

        $this->app = $app;
    }

    public function index()
    {

    }

    public function feed($items)
    {
        $items = explode('@', config('laravel-rss.items');

        $data['newsItems'] = $this->app->make($items[0])->getAllOnline();

        return Response::view('laravel-rss::rss', $data, 200, ['Content-Type' => 'application/atom+xml; chartset=UTF-8']);

    }

}
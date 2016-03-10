@foreach($feeds as $feed)
    <link rel="alternate" type="application/rss+xml" href="{{ url($feed['url']) }}" title="{{ $feed['title'] }}">
@endforeach

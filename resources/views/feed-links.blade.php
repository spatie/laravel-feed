@foreach($feeds as $feed)
    <link rel="alternate" type="application/rss+xml" href="{{ $feed['url'] }}" title="{{ $feed['title'] }}">
@endforeach

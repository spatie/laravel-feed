<?xml version="1.0" encoding="UTF-8" ?>

<feed xmlns="http://www.w3.org/2005/Atom">

    {{--<link href="http://blender.192.168.10.10.xip.io/nl/feed">--}}
    {{--<title>--}}
        {{--News--}}
    {{--</title>--}}
    {{--<updated>--}}
        {{--{{ \Carbon\Carbon::now()->toATOMString() }}--}}
    {{--</updated>--}}

    @foreach($meta as $key => $metaItem)
        @if($key == 'link')
            <{{ $key }} href="{{ $metaItem }}"></{{ $key }}>
        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif

    @endforeach

    @foreach( $newsItems as $newsItem)

        <entry>
            <title>
                {{ $newsItem->name }}
            </title>
            <link>{{ action('Front\NewsItemController@detail', [$newsItem->url]) }}</link>

            <id>
                {{ $newsItem->id }}
            </id>
            <summary>
                {{ $newsItem->present()->excerpt }}
            </summary>
            <updated>
                {{ $newsItem->updated_at }}
            </updated>

        </entry>

    @endforeach

</feed>

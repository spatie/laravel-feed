<?xml version="1.0" encoding="UTF-8" ?>

<feed xmlns="http://www.w3.org/2005/Atom">

    <link href="http://blender.192.168.10.10.xip.io/nl/feed"></link>
    <title>
        News
    </title>
    <updated>
        {{ \Carbon\Carbon::now()->toATOMString() }}
    </updated>

    @foreach($meta as $key => $metaItem)
        @if($key == 'link')
            <{{ $key }} href="{{ $metaItem }}"></{{ $key }}>
        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif

    @endforeach

    @foreach( $items as $item)

        <entry>
            <title>
                {{ $item['title'] }}
            </title>
            <link>{{ $item['link'] }}</link>

            <id>
                {{ $item['id'] }}
            </id>
            <summary>
                {{ $item['summary'] }}
            </summary>
            <updated>
                {{ $item['updated'] }}
            </updated>

        </entry>

    @endforeach

</feed>

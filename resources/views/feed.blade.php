<?=
    /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
    '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<feed xmlns="http://www.w3.org/2005/Atom">
    @foreach($meta as $key => $metaItem)
        @if($key === 'link')
            <{{ $key }} href="{{ url($metaItem) }}"></{{ $key }}>
        @elseif($key === 'title')
            <{{ $key }}><![CDATA[{{ $metaItem }}]]></{{ $key }}>
        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif
    @endforeach
    @foreach($items as $item)
        <entry>
            <title><![CDATA[{{ $item->getFeedItemTitle() }}]]></title>
            <link rel="alternate" href="{{ url($item->getFeedItemLink()) }}" />
            <id>{{ url($item->getFeedItemId()) }}</id>
            <author>
                <name> <![CDATA[{{ $item->getFeedItemAuthor() }}]]></name>
            </author>
            <summary type="html">
                <![CDATA[{!! $item->getFeedItemSummary() !!}]]>
            </summary>
            <updated>{{ $item->getFeedItemUpdated()->toAtomString() }}</updated>
        </entry>
    @endforeach
</feed>

<?php /* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */ ?>
<?= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    @foreach($meta as $key => $metaItem)
        @if($key === 'link')
            <{{ $key }} href="{{ url($metaItem) }}"></{{ $key }}>
        @else
            <{{ $key }}>{{ $metaItem }}</{{ $key }}>
        @endif
    @endforeach
    @foreach($items as $item)
        <entry>
            <title>{{ $item->getFeedItemTitle() }}</title>
            <link>{{ $item->getFeedItemLink() }}</link>
            <id>{{ $item->getFeedItemId() }}</id>
            <summary>
                <![CDATA[{{ $item->getFeedItemSummary() }}]]>
            </summary>
            <updated>{{ $item->getFeedItemUpdated()->toAtomString() }}</updated>
        </entry>
    @endforeach
</feed>

{
    "version": "https://jsonfeed.org/version/1.1",
    "title": "{{ $meta['title'] }}",
    "home_page_url": "{{ config('app.url') }}",
    "feed_url": "{{ url($meta['link']) }}",
    "language": "{{ $meta['language'] }}",
    "items": [@foreach($items as $item){
            "id": "{{ url($item->id) }}",
            "title": "{{ $item->title }}",
            "url": "{{ url($item->link) }}",
            "content_html": "{!! str_replace('"', '\\"', $item->summary) !!}",
            "summary": "{!! str_replace('"', '\\"', $item->summary) !!}",
            "date_published": "{{ $item->updated->toRfc3339String() }}",
            "date_modified": "{{ $item->updated->toRfc3339String() }}",
            "authors": [{ "name": "{{ $item->author }}" }],
@if($item->__isset('enclosure'))
            "attachments": [
                {
                    "url": "{{ url($item->enclosure) }}",
                    "mime_type": "{{ $item->enclosureType }}",
                    "size_in_bytes": {{ $item->enclosureLength }}
                }
            ],
@endif
            "tags": [ {!! implode(',', array_map(fn($c) => '"'.$c.'"', $item->category)) !!} ]
        }@if($item !== $items->last()),
@endif
        @endforeach

    ]
}

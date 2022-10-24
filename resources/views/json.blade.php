{
    "version": "https://jsonfeed.org/version/1.1",
    "title": "{{ $meta['title'] }}",
@if(!empty($meta['description']))
    "description": "{{ $meta['description'] }}",
@endif
    "home_page_url": "{{ config('app.url') }}",
    "feed_url": "{{ url($meta['link']) }}",
    "language": "{{ $meta['language'] }}",
@if(!empty($meta['image']))
    "icon": "{{ $meta['image'] }}",
@endif
    "authors": [@foreach($items->unique('authorName') as $item){
            "name": "{{ $item->authorName }}"
        }@if(! $loop->last),@endif
@endforeach

    ],
    "items": [@foreach($items as $item){
            "id": "{{ url($item->id) }}",
            "title": {!! json_encode($item->title) !!},
            "url": "{{ url($item->link) }}",
            "content_html": {!! json_encode($item->summary) !!},
            "summary": {!! json_encode($item->summary) !!},
            "date_published": "{{ $item->timestamp() }}",
            "date_modified": "{{ $item->timestamp() }}",
            "authors": [{ "name": {!! json_encode($item->authorName) !!} }],
@if($item->__isset('image'))
            "image": "{{ url($item->image) }}",
@endif
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
        }@if(! $loop->last),
@endif
        @endforeach

    ]
}

@foreach($feeds as $name => $title)
    <link rel="alternate" type="application/atom+xml" href="{{ route("feeds.{$name}") }}" title="{{ $title }}">
@endforeach

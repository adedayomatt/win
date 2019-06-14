<?php $max = 5 ?>
@if($tags->count() > 0)
    @foreach($tags as $tag)
        @if($loop->index >= $max)
            @break
        @endif
        <a href="{{route('tag.show',[$tag->slug])}}" class="tag">
            #{{$tag->name}}
        </a>
    @endforeach
    @if($tags->count() > $max)
        <small class="text-muted"> + {{$tags->count() - $max }} more</small>
    @endif
@endif


@if(isset($tags))
    <div>
        @foreach($tags as $tag)
            <a href="{{route('tag.show',[$tag->slug])}}" class="tag" data-toggle="tooltip" title="{{$tag->description}}">#{{$tag->name}}</a>&nbsp;
        @endforeach
    </div>
@endif

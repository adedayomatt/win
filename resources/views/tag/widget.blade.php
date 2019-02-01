<?php 
    $tags = $_tags::all();
?>
<div class="widget">
    <ul class="list-group ball-bullet">
        @if($tags->count() > 0)
            @foreach($tags as $tag)
                <li class="list-group-item" style="background-color: transparent">
                    <div class="d-flex">
                        <span class="bullet"></span>
                        <a class="tag" href="{{route('tag.show',[$tag->slug])}}">{{ $tag->name}}</a>
                    </div>
                    <small class="grey">{!!$tag->description()!!}</small>
                    <div>
                        <small class="mr-3"><span class="badge badge-secondary figure">{{$tag->posts->count()}}</span> posts </small>
                        <small><span class="badge badge-secondary figure">{{$tag->discussions->count()}}</span> discussions </small>
                    </div>  

                </li>
            @endforeach
            <div class="text-right">
                <a href="{{route('tags')}}">see all tags</a>
            </div>
        @else
            <li class="list-group-item">
                <small class="text-danger">No tag found</small>
            </li>
        @endif
    </ul> 
</div>

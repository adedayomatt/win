<?php 
    $tags = $_tags::all();
?>
<div class="widget">
    <div class="list-group ball-bullet">
        @if($tags->count() > 0)
            @foreach($tags as $tag)
                <div class="list-group-item" style="background-color: transparent">
                    <div class="d-flex">
                        <span class="bullet"></span>
                        <div>
                            <a class="tag" href="{{route('tag.show',[$tag->slug])}}">#{{$tag->name}}</a>
                        </div>
                    </div>
                    <small class="text-muted">{!!$tag->description()!!}</small>
                    <div class="d-flex justify-content-center">
                        <small class="mr-1">{{$tag->posts->count()}} posts </small>
                        <small class="mr-1">{{$tag->discussions->count()}} discussions </small>
                    </div>
                    <div class="pl-2">
                        @include('user.widgets.tiles',['users'=> $tag->users, 'max' => 3])
                    </div>
                </div>
            @endforeach
            <div class="text-right">
                <a href="{{route('tags')}}">see all tags</a>
            </div>
        @else
            <div class="list-group-item">
                <small class="text-danger">No tag found</small>
            </div>
        @endif
</div> 
</div>

<?php 
    $tags_collection = isset($tags) ? $tags : $_tags::orderby('name','asc')->take(3)->get();
?>
<div class="widget">
        @if($tags_collection->count() > 0)
        <div class="list-group ball-bullet">
            @foreach($tags_collection as $tag)
                <div class="list-group-item" syle="background-color: transparent">
                    <div class="d-flex">
                        <span class="bullet"></span>
                        <div>
                            <a class="tag" href="{{route('tag.show',[$tag->slug])}}">#{{$tag->name}}</a>
                        </div>
                    </div>
                    <div class="p-2">
                        <small class="text-muted">{!!$tag->description()!!}</small>
                        <div class="d-fle">
                            <small class="mr-1">{{$tag->trainings->count()}} trainings </small>
                            <small class="mr-1">{{$tag->discussions->count()}} discussions </small>
                        </div>
                        @if($tag->users->count() > 0)
                        <div class="pl-2">
                            <small class="text-muted mr-3">followed by </small> @include('user.widgets.tiles',['users'=> $tag->users, 'max' => 3])
                        </div>
                        @endif
                    </div>
                    
                </div>
            @endforeach
            
        </div> 
        @else
            <div class="content-box text-muted text-center">
                <small>No tag found</small>
            </div>
        @endif
</div>

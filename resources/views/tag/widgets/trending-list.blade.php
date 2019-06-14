<?php 
    $trendings =  $_tags::trending();
?>
<div class="widget">
        @if($trendings->count() > 0)
            <div class="list-group ball-bullet" style="max-height: 300px; overflow: auto">
                @foreach($trendings as $trend)
                    <div class="list-group-item" syle="background-color: transparent">
                        <div class="d-flex">
                            <span class="bullet"></span>
                            <div>
                                <a class="tag" href="{{route('tag.show',[$trend->tag->slug])}}">#{{$trend->tag->name}}</a>
                            </div>
                        </div>
                        <div class="p-2">
                            <div class="d-fle">
                                <small class="mr-1">{{$trend->trainings->count()}} trainings </small>
                                <small class="mr-1">{{$trend->discussions->count()}} discussions </small>
                            </div>
                            <div class="pl-2">
                            <small class="text-muted mr-3">followed by </small> @include('user.widgets.tiles',['users'=> $trend->tag->users, 'max' => 3])
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
            <div class="text-right">
                <a href="{{route('tags')}}">see all tags</a>
            </div> 
        @else
            <div class="content-box text-muted text-center">
                <small>No tag found</small>
            </div>
        @endif
</div>

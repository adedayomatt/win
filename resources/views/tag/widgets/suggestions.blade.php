<?php 
    $suggestions_collection =  isset($suggestions) ? $suggestions : $_tags::orderby('created_at', 'desc')->get();
?>
<div class="widget">
        @if($suggestions_collection->count() > 0)
            <div class="list-group" style="max-height: 300px; overflow: auto">
                @foreach($suggestions_collection as $suggestion)
                    <div class="list-group-item">
                        <div class="d-flex p-1">
                            <div>
                                <a class="tag d-block" href="{{route('tag.show',[$suggestion->slug])}}">#{{$suggestion->name}}</a>
                                @if(Auth::user()->isFollowing($suggestion))
                                    <small class="text-muted">Already following</small>
                                @endif
                            </div>
                            <div class="float-right ml-auto mr-1">
                                <button type="button" class="btn btn-sm btn-theme" onclick='javascript: addTag($(".tags-preview"),@json($suggestion))'> select</small>
                            </div>
                        </div>
                        <div class="p-2">
                            <div class="d-fle">
                                <small class="mr-1">{{$suggestion->trainings->count()}} trainings </small>
                                <small class="mr-1">{{$suggestion->discussions->count()}} discussions </small>
                            </div>
                            <div class="pl-2">
                                <small class="text-muted mr-3">followed by </small> @include('user.widgets.tiles',['users'=> $suggestion->users, 'max' => 3])
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
                <small>No suggestion </small>
            </div>
        @endif
</div>

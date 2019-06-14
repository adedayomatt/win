<?php
    $collection = isset($forum_w_collection) ? $forum_w_collection: $_forums::all();
?>
<div class="content-box widget">
        @if($collection->count() >0 )
            <ul class="list-group ball-bullet">
                @foreach($collection as $forum)
                    @include('forum.templates.list')
                @endforeach
            </ul>
        @else
            <div class="content-box text-muted text-center">
                <small> No forum found</small>
            </div>
        @endif
</div>
  


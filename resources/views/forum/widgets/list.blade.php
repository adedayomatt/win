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
            <div class="text-center" style="padding: 10px">
                <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No forum found</small>
            </div>
        @endif
</div>
  


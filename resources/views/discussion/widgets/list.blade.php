<?php
    $collection = isset($discussion_w_collection) ? $discussion_w_collection: $_discussions::all();
?>
<div class="widget my-1">
    @if($collection->count() >0 )
        <div class="list-group">
            @foreach($collection as $discussion)
                @include('discussion.templates.list')
            @endforeach
    </div>
    @else
        <div class="text-center" style="padding: 10px">
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No discussion found</small>
        </div>
    @endif
</div>
  


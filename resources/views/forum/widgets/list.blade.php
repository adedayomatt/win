<?php
    $title = isset($w_title) ? $w_title: 'Forums';
    $collection = isset($w_collection) ? $w_collection: $_forums::all();
?>
<div class="content-box widget">
        <div class="heading">
            <h5>{{$title}}</h5>
        </div>
        @if($collection->count() >0 )
            <ul class="list-group ball-bullet">
                @foreach($collection as $forum)
                    @include('forum.widgets.single')
                @endforeach
            </ul>
        @else
            <div class="text-center" style="padding: 10px">
                <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No forum found</small>
            </div>
        @endif
</div>
  


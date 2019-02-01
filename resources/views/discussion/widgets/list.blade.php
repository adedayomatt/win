<?php
    $title = isset($w_title) ? $w_title: 'Discussions';
    $collection = isset($w_collection) ? $w_collection: $_discussions::all();
?>
<div class="content-box">
    <h5>{{$title}}</h5>
</div>

<div class="content-box widget">
    @if($collection->count() >0 )
        <ul class="list-group icon-bullet">
            @foreach($collection as $discussion)
                @include('discussion.widgets.single')
            @endforeach
        </ul>
    @else
        <div class="text-center" style="padding: 10px">
            <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No discussion found</small>
        </div>
    @endif
</div>
  


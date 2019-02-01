<?php
    $title = isset($w_title) ? $w_title: 'Posts';
    $collection = isset($w_collection) ? $w_collection: $_posts::all();
?>
<div class="content-box">
    <h5>{{$title}}</h5>
</div>

<div class="content-box widget">
        @if($collection->count() >0 )
            <div class="list-group">
                @foreach($collection as $post)
                    @include('post.widgets.single')
                @endforeach
            </div>
        @else
            <div class="text-center" style="padding: 10px">
                <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No post found</small>
            </div>
        @endif
   </div>
  


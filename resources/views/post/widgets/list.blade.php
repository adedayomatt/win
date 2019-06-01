<?php
    $collection = isset($post_w_collection) ? $post_w_collection: $_posts::all();
?>
<div class="content-box widget">
        @if($collection->count() >0 )
            <div class="list-group">
                @foreach($collection as $post)
                    @include('post.templates.list')
                @endforeach
            </div>
        @else
            <div class="text-center" style="padding: 10px">
                <small class="text-danger"><i class="fa fa-exclamation-triangle"></i>  No post found</small>
            </div>
        @endif
   </div>
  


<?php
    $title = isset($w_title) ? $w_title: 'Posts';
    $collection = isset($w_collection) ? $w_collection: $_posts::all();
?>
<div class="card widget">
       <div class="card-header">
            <h5>{{$title}}</h5>
            <form action="">
                <input class="form-control" type="text" placeholder="search for post...">
            </form>
        </div>
       <div class="card-body p-0">
            @if($collection->count() >0 )
                <div class="list-group image-bullet">
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
   </div>
  


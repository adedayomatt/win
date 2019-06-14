<?php
    $collection = isset($training_w_collection) ? $training_w_collection: $_trainings::all();
?>
<div class="widget my-1">
        @if($collection->count() >0 )
            <div class="list-group">
                @foreach($collection as $training)
                    @include('training.templates.list')
                @endforeach
            </div>
        @else
            <div class="content-box text-center text-muted">
                <small>No training found</small>
            </div>
        @endif
   </div>
  

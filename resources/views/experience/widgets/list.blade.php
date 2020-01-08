<?php
    $collection = isset($experience_w_collection) ? $experience_w_collection: $_experiences::all();
?>
<div class="widget my-1">
        @if($collection->count() >0 )
            <div class="list-group">
                @foreach($collection as $experience)
                    @include('experience.templates.list')
                @endforeach
            </div>
        @else
            <div class="content-box text-center text-muted">
                <small>No experience found</small>
            </div>
        @endif
   </div>
  

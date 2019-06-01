@if(isset($carousel_collection) && $carousel_collection->count() > 0)
<?php 
     $carousel_items = (isset($carousel_layout)) ? $carousel_layout : ['xs' => 2, 'sm' => 3, 'md' => 4, 'lg' => 4];
?>
    <div class="owl-carousel owl-theme" data-xs="{{$carousel_items['xs']}}" data-sm="{{$carousel_items['sm']}}" data-md="{{$carousel_items['md']}}" data-lg="{{$carousel_items['lg']}}">
        @if(isset($carousel_template))
            @foreach($carousel_collection as $item)
                @include($carousel_template)
            @endforeach
        @else
        <p class="text-muted text-center">No template to use</p>
        @endif
    </div>
@endif
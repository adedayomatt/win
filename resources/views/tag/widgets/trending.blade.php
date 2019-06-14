@if($_tags::trending()->count() > 0)
    @include('components.owl-carousel', ['carousel_collection' => $_tags::trending(), 'carousel_template'=> 'tag.templates.carousel-trending'])
@else
    <div class="content-box text-muted text-center">
        <small>No trends yet</small> 
    </div>
@endif
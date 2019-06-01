
@if(isset($contributors))
    @include('components.owl-carousel',['carousel_collection' => $contributors, 'carousel_template' => 'user.templates.contributors'])
@else
    <div class="content-box text-muted text-center">
        No contributor
    </div>
@endif
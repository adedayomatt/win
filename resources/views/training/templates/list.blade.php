<div class="content-box p-0">
    <div class="mb-2">
        <img src="{{$training->cover()['src']}}" alt="{{$training->cover()['alt']}}" width="100%">
    </div>
    <div class="mt-2 p-2">
        <div>
            @if(!$discussion->isTrashed())
            <h6><a href="{{route('training.show',[$training->slug])}}">{{$training->title}}</a></h6>
            @else
                <h6 class="text-muted" data-toggle="tooltip" title="training deleted">{{$training->title}}</h6>
            @endif
            @include('training.widgets.meta')
        </div>
        {!! $training->content() !!}
        @include('tag.widgets.inline', ['tags' => $training->tags])
    </div>
</div>
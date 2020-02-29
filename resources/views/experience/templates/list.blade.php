<div class="content-box p-0">
    @if ($experience->photos()->count() > 0)
        <div class="mb-2">
            <img src="{{$experience->cover()['src']}}" alt="{{$experience->cover()['alt']}}" width="100%">
        </div>
    @endif
    <div class="mt-2 p-2">
        <div>
            @if(!$experience->isTrashed())
            <h6><a href="{{route('experience.show',[$experience->slug])}}">{{$experience->title}}</a></h6>
            @else
                <h6 class="text-muted" data-toggle="tooltip" title="experience deleted">{{$experience->title}}</h6>
            @endif
            @include('experience.widgets.meta')
        </div>
        {!! $experience->content() !!}
        @include('tag.widgets.inline', ['tags' => $experience->tags])
    </div>
</div>
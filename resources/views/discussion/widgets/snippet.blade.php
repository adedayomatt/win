@if($discussion->isTrashed())
    <div class="content-box text-muted" data-toggle="tooltip" title="discussion deleted">
        <strong class="d-block">{{$discussion->title}}</strong>
        <small>{!!$discussion->content()!!}</small>
    </div>
@else
    <div class="snippet">
            <div class="float-right bg-info py-1 px-2 small" style="color:#fff">discussion</div>
            <strong><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></strong>
            <div class="pl-2">
                @include('discussion.widgets.meta')
            </div>
            {!!$discussion->content()!!} 
            @if($discussion->fromExperience())
                <div class="ml-2">
                    @include('experience.widgets.snippet',['experience' => $discussion->experience()])
                </div>
            @endif
        @include('tag.widgets.inline', ['tags' => $discussion->tags])
        <div style="border-top: 1px solid #f2f2f2" class="pt-1 d-flex">
            <div class="pl-2">
                <span class="small text-muted mr-2">participating: </span>
                @include('discussion.widgets.contributors-mini',['discussion' => $discussion])
            </div>
        </div>
    </div>
@endif

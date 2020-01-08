@if($experience->isTrashed())
    <div class="content-box text-muted" data-toggle="tooltip" title="experience deleted">
        <strong class="d-block">{{$discussion->experience()->title}}</strong>
        <small>{!!$discussion->experience()->content()!!}</small>
    </div>
@else
<div class="snippet">
    <div>
        <div class="float-right bg-primary  py-1 px-2 small" style="color:#fff">experience</div>
        <a href="{{route('experience.show',$experience->slug)}}"><strong>{{$experience->title}}</strong></a>
    </div>
    <div>
        <div class="ml-2">
        @include('experience.widgets.meta')
        </div>
    </div>
    @if ($experience->photos()->count() > 0)
        <div>
            <img class="" src="{{$experience->cover()['src']}}" alt="{{$experience->cover()['alt']}}" width="100%">
        </div>
    @endif
    <div class="">
        {!!$experience->content()!!} 
    </div>
    @include('tag.widgets.inline',['tags'=> $experience->tags])
</div>
@endif
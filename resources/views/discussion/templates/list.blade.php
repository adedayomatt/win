<div class="list-group-item my-1 content-box" >
    <div class="px-2 ">
        <div class="d-flex">
            <p>
                @if(!$discussion->isTrashed())
                    <a class="mr-2 discussion" href="{{route('discussion.show',[$discussion->slug])}}"><strong>{{ $discussion->title}}</strong></a>
                @else
                    <strong class="text-muted" data-toggle="tooltip" title="discussion deleted">{{$discussion->title}}</strong>
                @endif
                
                @if($discussion->fromExperience())
                    on the experience 
                    @if($discussion->experience()->isTrashed())
                        <strong class="text-muted" data-toggle="tooltip" title="experience deleted">{{$discussion->experience()->title}}</strong>
                    @else
                        <a href="{{route('experience.show',$discussion->experience()->slug)}}"><strong>  {{$discussion->experience()->title}}</strong></a>
                    @endif
                @endif            
            </p> 
        </div>
        <div>
            @if(!$discussion->isTrashed())
                @include('discussion.widgets.meta')
            @endif
            {!!$discussion->content()!!}
            @include('tag.widgets.inline', ['tags' => $discussion->tags])
        </div>
        <div style="border-top: 1px solid #f2f2f2" class="pt-1 pl-2">
            <span class="small text-muted mr-2">participating: </span>
            @include('discussion.widgets.contributors-mini',['discussion' => $discussion])
        </div>

    </div>

</div>

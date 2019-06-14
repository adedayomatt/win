<div class="list-group-item my-1 content-box" >
    <div class="px-2 ">
        <div class="d-flex">
            <p>
                @if(!$discussion->isTrashed())
                    <a class="mr-2 discussion" href="{{route('discussion.show',[$discussion->slug])}}"><strong>{{ $discussion->title}}</strong></a>
                @else
                    <strong class="text-muted" data-toggle="tooltip" title="discussion deleted">{{$discussion->title}}</strong>
                @endif

                
                @if($discussion->fromTraining())
                    on the training 
                    @if($discussion->training()->isTrashed())
                        <strong class="text-muted" data-toggle="tooltip" title="training deleted">{{$discussion->training()->title}}</strong>
                    @else
                        <a href="{{route('training.show',$discussion->training()->slug)}}"><strong>  {{$discussion->training()->title}}</strong></a>
                    @endif
                @endif            
            </p> 
        </div>
        <div >
            @include('discussion.widgets.meta')
            {!!$discussion->content()!!}
            @include('tag.widgets.inline', ['tags' => $discussion->tags])
        </div>
        <div style="border-top: 1px solid #f2f2f2" class="pt-1 pl-2">
            <span class="small text-muted mr-2">participating: </span>
            @include('discussion.widgets.contributors-mini',['discussion' => $discussion])
        </div>

    </div>

</div>

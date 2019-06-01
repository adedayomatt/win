<div class="list-group-item my-1 content-box" >
    <div class="px-2 ">
        <div class="d-flex">
            <p>
                <a class="mr-2 discussion" href="{{route('discussion.show',[$discussion->slug])}}"><strong>{{ $discussion->title}}</strong></a>
                @if($discussion->fromPost())
                    on the post <a href="{{route('post.show',$discussion->post->slug)}}"><strong>  {{$discussion->post->title}}</strong></a>
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

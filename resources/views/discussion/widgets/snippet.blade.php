<div class="snippet">
            <strong>{{$discussion->title}}</strong>
            <div class="pl-2">
                @include('discussion.widgets.meta')
            </div>
        {!!$discussion->content()!!} 
        @if($discussion->fromPost())
            <div class="ml-3">
                @include('post.widgets.snippet',['post' => $discussion->post])
            </div>
        @endif
         <a href="{{route('discussion.show',[$discussion->slug])}}">see full discussion</a>
    @include('tag.widgets.inline', ['tags' => $discussion->tags])
    <div style="border-top: 1px solid #f2f2f2" class="pt-1 d-flex">
        <div class="pl-2">
            <span class="small text-muted mr-2">participating: </span>
            @include('discussion.widgets.contributors-mini',['discussion' => $discussion])
        </div>
    </div>

</div>

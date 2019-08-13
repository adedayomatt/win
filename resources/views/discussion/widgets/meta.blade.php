<div>
    @include('user.widgets.snippet',['user' => $discussion->user])
    <small class="mr-2"> in <a href="{{route('forum.show',$discussion->forum->slug)}}">{{$discussion->forum->name}}</a></small>
    <small class="mr-2"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$discussion->comments->count()}} comments </a></small>
    <small class="mr-2">started {{$discussion->created_at->diffForHumans()}}</small>
</div>
<li class="list-group-item">
    <div class="d-flex shift-left">
        <span class="bullet"></span>
        <a class="mr-2 " href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a>
        <span class="ml-auto">{{$forum->discussions->count()}} discussions</span>
    </div>
    @if($forum->description != '')
        <small class="text-muted">{!!$forum->description()!!}</small>
    @endif
    <div>
        <img src="{{$forum->user->avatar()['src']}}" alt="" style="width: 30px; height: 30px; border-radius: 50%; border: 2px solid #fff" data-toggle="tooltip" title="{{$forum->user->username()}}">
        <small class="text-muted"> <a href="{{route('user.profile',[$forum->user->username])}}">{{$forum->user->fullname()}}</a></small>
    </div>
</li>

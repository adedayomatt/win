<div style="height: 30px">
    @if($discussion->contributors->count() > 0)
        @foreach($discussion->contributions()->take(3)->get() as $contribution)
            <a href="{{route('user.profile',[$contribution->user->username])}}">
                <img src="{{$contribution->user->avatar()['src']}}" alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-left: -10px" data-toggle="tooltip" title="{{$contribution->user->fullname()}}">
            </a>
        @endforeach
        @if($discussion->contributors->count() > 3)
            <small class="text-muted"> + {{$discussion->contributors->count() - 3 }} others</small>
        @endif
    @else
        <small class="text-muted mx-1">No contributor yet @if(!$discussion->isTrashed()), <a href="{{route('discussion.show',[$discussion->slug])}}#comment">contribute</a> @endif</small>
    @endif
</div>

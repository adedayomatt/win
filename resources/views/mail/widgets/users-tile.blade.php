@if($users->count() > 0)
    @foreach($users as $user)
        @if($loop->index >= $max)
            @break
        @endif
        <a href="{{route('user.profile',[$user->username])}}">
            <img src="{{$user->avatar()['src']}}" alt="" style="width: 30px; height: 30px; border-radius: 50%; margin-left: -10px; border: 2px solid #fff"title="{{$user->fullname()}}">
        </a>
    @endforeach
    @if($users->count() > $max)
        <small class="text-muted"> + {{$users->count() - $max }} others</small>
    @endif
@endif

<div class="d-flex">
    <img src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}" class="avatar avatar-sm">
    <div style="margin-left: 5px; padding-top: 7px">
        <strong class="d-block">{{$user->fullname()}}</strong>
        <a href="{{route('user.profile',[$user->username])}}">{{$user->username()}}</a>
    </div>
</div>
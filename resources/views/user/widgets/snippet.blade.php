   <div class="d-flex">
       <img src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}" class="avatar avatar-sm">
        <div class="ml-2 pt-1">
            <strong>{{$user->fullname()}}</strong>
            <br>
            <a href="{{route('user.profile',[$user->username])}}">{{$user->username()}}</a>
        </div>
    </div>

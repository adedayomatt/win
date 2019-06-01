   <div class="{{isset($display) ? $display : 'd-flex'}}">
       <img src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}" class="avatar avatar-sm">
        <div class="ml-2 pt-1" >
                @if(isset($limit))
                    <div style="height: 50px">
                        <strong class="d-block">{{str_limit($user->fullname(), 13)}}</strong>
                        <a href="{{route('user.profile',[$user->username])}}">{{str_limit($user->username(),10)}}</a>
                    </div>
                @else
                    <strong class="d-block">{{$user->fullname()}}</strong>
                    <a href="{{route('user.profile',[$user->username])}}">{{$user->username()}}</a>
                @endif
            <br>
        </div>
    </div>

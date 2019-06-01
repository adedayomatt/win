<div class="item">
    @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-block', 'limit' => true])
    <div class="text-muted text-center">
        <small><a href="{{route('user.profile',[$item->user->username])}}#contributions">{{$item->contributions}} contributions</a></small>
    </div>
</div>
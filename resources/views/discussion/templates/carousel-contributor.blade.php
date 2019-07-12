<div class="item">
    @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-block', 'limit' => true])
    <div class="text-center text-muted">
    <hr>
        <small class="d-block">{{str_limit($item->user->educationStatus(), 60)}}</small>
        <small class="d-block">{{str_limit($item->user->workStatus(), 60)}}</small>
    </div>
    <div class="text-right">
        <small><a href="{{route('user.profile',[$item->user->username])}}#contributions">{{$item->contributions}} contributions</a></small>
    </div>
</div>
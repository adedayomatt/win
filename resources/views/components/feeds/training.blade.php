<?php $training = $feed ?>
<div class="feed">
    <div>
        <strong><a href="{{route('user.profile',[$training->user->username])}}">{{$training->user->fullname()}}</a></strong> published a new training
        <br>
        <small class="grey">{{$training->created_at->diffForHumans()}}</small>
    </div>
    @include('training.widgets.snippet')
</div>
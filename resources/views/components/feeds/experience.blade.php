<?php $experience = $feed ?>
<div class="feed">
    <div>
        <strong><a href="{{route('user.profile',[$experience->user->username])}}">{{$experience->user->fullname()}}</a></strong> published a new experience
        <br>
        <small class="grey">{{$experience->created_at->diffForHumans()}}</small>
    </div>
    @include('experience.widgets.snippet')
</div>
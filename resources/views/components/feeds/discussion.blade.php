<?php $discussion = $feed ?>
<div class="feed">
    <strong><a href="{{route('user.profile',[$discussion->user->username])}}">{{$discussion->user->fullname()}}</a></strong> started a new discussion
    @if($discussion->fromExperience())
        on <a href="#">{{$discussion->experience()->user->fullname()}}</a>'s experience
    @endif
    <br>
    <small class="grey">{{$discussion->created_at->diffForHumans()}}</small>
    @include('discussion.widgets.snippet')
</div>
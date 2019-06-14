<?php $discussion = $feed ?>
<div class="feed">
    <strong><a href="{{route('user.profile',[$discussion->user->username])}}">{{$discussion->user->fullname()}}</a></strong> started a new discussion
    @if($discussion->fromTraining())
        on <a href="#">{{$discussion->training()->user->fullname()}}</a>'s training
    @endif
    <br>
    <small class="grey">{{$discussion->created_at->diffForHumans()}}</small>
    @include('discussion.widgets.snippet')
</div>
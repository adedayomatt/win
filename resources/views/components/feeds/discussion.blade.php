<?php $discussion = $feed ?>
<div class="feed content-box">
    <strong><a href="{{route('user.profile',[$discussion->user->username])}}">{{$discussion->user->fullname()}}</a></strong> started a new discussion
    @if($discussion->fromPost())
        on <a href="#">{{$discussion->post->user->fullname()}}</a>'s post
    @endif
    <br>
    <small class="grey">{{$discussion->created_at->diffForHumans()}}</small>
    @include('discussion.widgets.snippet')
</div>
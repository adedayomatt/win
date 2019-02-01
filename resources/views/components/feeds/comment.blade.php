<?php $comment = $feed ?>
<div class="feed content-box">
    <div>
        <strong><a href="#">{{$comment->user->fullname()}}</a></strong> commented on a discussion
        <br>
        <small class="grey">{{$comment->created_at->diffForHumans()}}</small>
    </div>
    @include('comment.snippet')
</div>
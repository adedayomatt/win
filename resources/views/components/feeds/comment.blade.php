<?php $comment = $feed ?>
        <div class="feed">
            <div>
                <strong><a href="{{route('user.profile',[$comment->user->username])}}">{{$comment->user->fullname()}}</a></strong> commented on a discussion
                <br>
                <small class="grey">{{$comment->created_at->diffForHumans()}}</small>
            </div>
            @include('comment.snippet')
        </div>

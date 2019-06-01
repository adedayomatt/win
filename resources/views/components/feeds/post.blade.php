<?php $post = $feed ?>
<div class="feed">
    <div>
        <strong><a href="{{route('user.profile',[$post->user->username])}}">{{$post->user->fullname()}}</a></strong> added a new post
        <br>
        <small class="grey">{{$post->created_at->diffForHumans()}}</small>
    </div>
    @include('post.widgets.snippet')
</div>
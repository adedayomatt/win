<div class="list-group image-bullet">
    <?php
        $comments = $discussion->comments()->where('comment_id',null)->orderby('created_at','desc')->get();//get the direct replies alone
    ?>
   @foreach($comments as $comment) 
        <div class="list-group-item">
           @include('user.widgets.snippet', ['user' => $comment->user])
            <small class="grey">{{$comment->created_at->diffForHumans()}}</small>
            {!!$comment->content!!}
            @include('comment.meta')
            @include('comment.replies')
        </div>
   @endforeach
</div>

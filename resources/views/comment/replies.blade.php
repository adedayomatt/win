@if($comment->replies->count() > 0)
    <div class="collapse comment-replies px-2" id="comment-{{$comment->id}}-replies">
        <div class="list-group image-bullet">
            <?php
                $replies = $comment->replies()->orderby('created_at','desc')->get()
            ?>
            @foreach($replies as $reply)
                <div class="list-group-item">
                    <?php $user= $reply->user?>
                    @include('user.widgets.snippet')
                    <small class="grey">{{$reply->created_at->diffForHumans()}}</small>
                    <br>
                    {!!$reply->content!!}
                </div>
            @endforeach
        </div>
    </div>
@endif
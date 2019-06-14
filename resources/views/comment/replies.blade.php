@if($comment->replies->count() > 0)
    <div class="collapse comment-replies px-2" id="comment-{{$comment->id}}-replies">
        <div class="list-group image-bullet" >
            <?php
                $replies = $comment->replies()->orderby('created_at','desc')->get()
            ?>
            @foreach($replies as $reply)
                <div class="list-group-item" style="background-color: inherit">
                    <div style="background-color: #fff;padding: 5px; border-radius: 5px; margin-bottom: 5px">
                        <div class="d-flex">
                            <img src="{{$comment->user->avatar()['src']}}" alt="{{$reply->user->avatar()['alt']}}" class="avatar avatar-sm">
                            <div class="ml-2 pt-1" >
                                <strong class="d-block">{{$reply->user->fullname()}}</strong>
                                <a href="{{route('user.profile',[$reply->user->username])}}">{{$reply->user->username()}}</a>
                                <small class="text-muted ml-1">{{$reply->created_at->diffForHumans()}}</small>
                            </div>
                        </div>
                        {!!$reply->content!!}
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endif
<div class="pl-5">
    <div class="d-flex">
        <div class="mr-3">
            @auth()
                <form action="{{route('comment.like',[$comment->id])}}" class="comment-like" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 like-unlike" data-role="{{$comment->isLiked() ? 'unlike' : 'like'}}" data-count="{{$comment->likes->count()}}"><i class="fas fa-thumbs-up"></i></button>
                    <small class="ml-2 pt-1" data-toggle="tooltip" title="{{$comment->likes()->count().' person(s) liked this'.($comment->isLiked() ? ' (including You)' : '')}}"><strong class="theme-color likes-counter">{{$comment->likes->count()}}</strong> likes</small>
                </form>
            @endauth
            @guest()
                <button class="btn btn-link p-0 grey" data-toggle="tooltip" title="sign in to like {{$comment->user->firstname}}'s comment"><i class="far fa-thumbs-up"></i></button>
                <small class="ml-2 pt-1" data-toggle="tooltip" title="{{$comment->likes()->count().' person(s) liked this'.($comment->isLiked() ? ' (including You)' : '')}}"><strong class="theme-color likes-counter">{{$comment->likes->count()}}</strong> likes</small>
            @endguest
        </div>
        <small class="mr-2 pt-1" data-toggle="collapse" data-target="#comment-{{$comment->id}}-replies" aria-expanded="false" aria-controls="comment-{{$comment->id}}-replies" title="{{$comment->replies()->count().' person(s) replied to '. $comment->user->fullname()}}"><strong class="theme-color" >{{$comment->replies->count()}}</strong> replies</small>
        @auth()
            <small class="pt-1" data-toggle="tooltip" title="reply to {{$comment->user->fullname()}}'s comment on {{$discussion->title}}">
                <span data-toggle="modal" data-target="#commentReply" data-discussion="{{$discussion->title}}" data-commenter="{{$comment->user->fullname()}}" data-comment="{{$comment->content()}}" data-reply-form="#comment-{{$comment->id}}">reply</span>
            </small>

            <!--reply form-->
            <div class="ml-5" id="comment-{{$comment->id}}" style="display: none">
                <form action="{{route('comment.reply',[$comment->id])}}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_comment" value="{{$comment->id}}">
                    <div class="form-group">
                        <textarea name="comment" placeholder="replying {{$comment->user->fullname()}}..." class="form-control"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-secondary">Reply</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--reply form-->
        @endauth

        @guest()
            <small class="pt-1" data-toggle="tooltip" title="sign in to reply to {{$comment->user->fullname()}}'s comment on {{$discussion->title}}">
                <span class="grey">reply</span>
            </small>
        @endguest

    </div>
</div>
<div class="list-group image-bullet">
    <div class="infinite-scroll">
        @foreach($comments as $comment) 
            <div class="list-group-item comment" style="background-color: inherit">
                <div style="background-color: #f7f7f7; border-radius: 5px; padding: 5px; margin-bottom: 5px">
                    <div class="d-flex">
                        <img src="{{$comment->user->avatar()['src']}}" alt="{{$comment->user->avatar()['alt']}}" class="avatar avatar-sm">
                        <div class="ml-2 pt-1" >
                            <strong class="d-block">{{$comment->user->fullname()}}</strong>
                            <a href="{{route('user.profile',[$comment->user->username])}}">{{$comment->user->username()}}</a>
                            <small class="text-muted ml-1">{{$comment->created_at->diffForHumans()}}</small>
                        </div>
                    </div>
                    {!!$comment->content!!}
                    @include('comment.meta')
                    @include('comment.replies')
                </div>
            </div>
        @endforeach
        {{$comments->links()}}
    </div>
</div>

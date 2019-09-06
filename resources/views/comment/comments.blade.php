<comments target="discussion" discussion_id="{{$discussion->id}}" ></comments>

{{-- <div class="list-group image-bullet">
    <div class="infinite-scroll">
        @foreach($comments as $comment)
            <div class="list-group-item comment" id="{{$comment->user->username}}-comment-{{$comment->id}}" style="background-color: inherit">
                <div style="background-color: #f7f7f7; border-radius: 5px; padding: 5px; margin-bottom: 5px;">
                    <div class="d-flex">
                        <img src="{{$comment->user->avatar()['src']}}" alt="{{$comment->user->avatar()['alt']}}" class="avatar avatar-sm">
                        <div class="ml-2 pt-1" >
                            <strong class="d-block">{{$comment->user->fullname()}}</strong>
                            <a href="{{route('user.profile',[$comment->user->username])}}">{{$comment->user->username()}}</a>
                            <small class="text-muted ml-1">{{$comment->created_at->diffForHumans()}}</small>
                        </div>
                    </div>
                    {!!$comment->content!!}
                    @if(isset($contributor) && $comment->isReply())
                        <div class="text-muted ml-3">
                            replying to {{$comment->comment->user->fullname()}} <a href="{{route('user.profile',[$comment->comment->user->username])}}">{{$comment->comment->user->username()}}</a>
                            <div>{!!$comment->comment->content!!}</div>
                        </div>
                    @else
                        @include('comment.meta')
                        @include('comment.replies')
                    @endif 
                </div>
            </div>
        @endforeach
        {{$comments->appends($_GET)->links()}}
    </div>
</div> --}}

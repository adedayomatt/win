<q>{{$comment->content}}</q>
<div class="text-muted">
    <small style="margin: 0 5px">{{$comment->likes->count()}} likes</small>
    <small style="margin: 0 5px">{{$comment->replies_count}} replies</small>
</div>
<div  style="margin: 5px 0">
    <a href="{{route('comment.show',[$comment->id])}}" class="btn">view comment</a>
</div>
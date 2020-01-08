<strong><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></strong>
@if($discussion->fromExperience())
 on the experience <a href="{{route('experience.show',[$discussion->experience()->slug])}}">{{$discussion->experience()->title}}</a>
@endif
<div class="">
    @include('mail.snippets.user',['user' => $discussion->user])
    <small class="mr-2"> in <a href="{{route('forum.show',$discussion->forum->slug)}}">{{$discussion->forum->name}}</a></small>
    <small class="mr-2"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$discussion->comments->count()}} comments </a></small>
    <small>started {{$discussion->created_at->diffForHumans()}}</small>
</div>
{!!$discussion->content()!!}
<div style="margin: 5px 0">
    @include('mail.widgets.tags-tile',['tags' => $discussion->tags])
</div>

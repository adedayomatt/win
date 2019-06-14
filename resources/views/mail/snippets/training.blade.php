<imgtr src="{{$training->cover()['src']}}" alt="{{$training->cover()['alt']}}" width="100%">
<strong><a href="{{route('training.show',$training->slug)}}">{{$training->title}}</a></strong>
<div>
    @include('mail.snippets.user',['user' => $training->user])
    <small><a href="{{route('training.show',[$training->slug])}}#discussions">{{$training->discussions->count()}} discussions</a></small>
    <small>{{$training->photos()->count()}} photos</small>
    <small>{{$training->videos()->count()}} videos</small>
    <small>pubished {{$training->created_at->diffForHumans()}}</small>
</div>
{!!$training->content()!!}
@include('mail.widgets.tags-tile',['tags' => $training->tags])
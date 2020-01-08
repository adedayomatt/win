<imgtr src="{{$experience->cover()['src']}}" alt="{{$experience->cover()['alt']}}" width="100%">
<strong><a href="{{route('experience.show',$experience->slug)}}">{{$experience->title}}</a></strong>
<div>
    @include('mail.snippets.user',['user' => $experience->user])
    <small><a href="{{route('experience.show',[$experience->slug])}}#discussions">{{$experience->discussions->count()}} discussions</a></small>
    <small>{{$experience->photos()->count()}} photos</small>
    <small>{{$experience->videos()->count()}} videos</small>
    <small>pubished {{$experience->created_at->diffForHumans()}}</small>
</div>
{!!$experience->content()!!}
@include('mail.widgets.tags-tile',['tags' => $experience->tags])
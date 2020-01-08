@include('user.widgets.snippet', ['user' => $experience->user])
<div class="text-muted">
    <small><a href="{{route('experience.show',[$experience->slug])}}#discussions">{{$experience->discussions->count()}} discussions</a></small>
    <small>{{$experience->photos()->count()}} photos</small>
    <small>{{$experience->videos()->count()}} videos</small>
    <small>pubished {{$experience->created_at->diffForHumans()}}</small>
</div>


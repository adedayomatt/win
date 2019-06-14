@include('user.widgets.snippet', ['user' => $training->user])
<div class="text-muted">
    <small><a href="{{route('training.show',[$training->slug])}}#discussions">{{$training->discussions->count()}} discussions</a></small>
    <small>{{$training->photos()->count()}} photos</small>
    <small>{{$training->videos()->count()}} videos</small>
    <small>pubished {{$training->created_at->diffForHumans()}}</small>
</div>


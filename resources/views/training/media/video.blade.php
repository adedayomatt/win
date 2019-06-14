<?php //dd($media) ?>
<video src="{{asset('storage/trainings/media/'.$media->slug)}}" controls preload="meta" traininger="{{$training->cover()['src']}}" width="100%"></video>
<?php //dd($media) ?>
<video src="{{asset('storage/experiences/media/'.$media->slug)}}" controls preload="meta" experienceer="{{$experience->cover()['src']}}" width="100%"></video>
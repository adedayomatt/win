<?php $user = $post->user ?>
@include('user.widgets.snippet')
<small class=""> in <a href="{{route('post.category.show',$post->category->slug)}}">{{$post->category->name}}</a></small>
<small><a href="{{route('post.show',[$post->slug])}}#discussions"><span class="badge badge-secondary figure">{{$post->discussions->count()}}</span> discussions</a></small>


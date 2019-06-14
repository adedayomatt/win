<div class="item">
   <strong class="d-block text-center" style="height: 40px"><a href="{{route('training.show',[$item->slug])}}">{{str_limit($item->title,50)}}</a></strong> 
   <small class="d-block text-center text-muted">{{$item->discussions->count()}} discussions</small>
   <div class="text-center">
        @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-flex', 'limit' => true])
   </div>
</div>
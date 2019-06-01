<div class="item">
   <strong class="d-block text-center"><a href="{{route('forum.show',[$item->slug])}}">{{str_limit($item->name, 10)}}</a></strong> 
   <small class="d-block text-center text-muted">{{$item->discussions->count()}} discussions</small>
   <div class="text-center">
        @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-block', 'limit' => true])
   </div>
   <div style="border-top: 1px solid #f2f2f2; height: 40px" class="pt-1">
      @if($item->contributors()->count() > 0)
         @include('user.widgets.tiles',['users'=> $item->contributors(), 'max' => 3])
      @else
         <small class="text-muted">No participant</small>
      @endif
   </div>
</div>
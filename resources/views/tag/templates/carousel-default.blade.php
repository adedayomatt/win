<div class="item">
   <strong class="d-block text-center"><a href="{{route('tag.show',[$item->slug])}}" class="tag" data-toggle="tooltip" title="{{$item->name}}">{{str_limit('#'.$item->name, 10)}}</a></strong> 
   <div class="d-flex justify-content-center text-muted">
      <small class="mr-2">{{$item->discussions->count()}} discussions</small>
      <small class="mr-2">{{$item->experiences->count()}} experiences</small>
   </div>

   <div style="border-top: 1px solid #f2f2f2; height: 50px" class="pt-1">
      @if($item->users->count() > 0)
         <small class="d-block text-muted">followed by</small>
         @include('user.widgets.tiles',['users'=> $item->users, 'max' => 3])
      @else
         <small class="text-muted">No follower</small>
      @endif
   </div>
  
</div>
<div class="item">
   <strong class="d-block text-center"><a href="{{route('tag.show',[$item->tag->slug])}}">#{{$item->tag->name}}</a></strong> 
   <div class="d-flex justify-content-center text-muted">
      <small class="mr-2">{{$item->discussions->count()}} discussions</small>
      <small class="mr-2">{{$item->posts->count()}} posts</small>
   </div>
   <div style="border-top: 1px solid #f2f2f2" class="pt-1">
      <small class="d-block text-muted">followed by</small>
      @include('user.widgets.tiles',['users'=> $item->tag->users, 'max' => 3])
   </div>
</div>
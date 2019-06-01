<div class="item">
   <strong class="d-block text-center" style="height: 40px"><a href="{{route('discussion.show',[$item->slug])}}">{{str_limit($item->title,50)}}</a></strong> 
   <small class="d-block text-center text-muted">{{$item->comments->count()}} comments</small>
   <div class="text-center">
        @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-block', 'limit' => true])
      <small class="text-muted">started {{$item->created_at->diffForHumans()}}</small>
      
      <div style="border-top: 1px solid #f2f2f2; border-bottom: 1px solid #f2f2f2" class="py-1">
        <div class="small text-muted">participating</div>
         @include('discussion.widgets.contributors-mini',['discussion' => $item])
      </div>
      <div class="py-1">
         <form action="#" method="post">
            @csrf
            <input type="hidden" value="{{$user->id}}" name="users[]">
            <a href="{{route('discussion.show', $item->discussion->slug)}}" class="btn btn-sm btn-secondary btn-block">contribute</a>
            <!-- <button class="btn btn-sm btn-secondary btn-block">Contribute</button> -->
         </form>
      </div>
   </div>
</div>
<div class="item">
   <strong class="d-block text-center" style="height: 40px"><a href="{{route('discussion.show',[$item->slug])}}">{{str_limit($item->title,50)}}</a></strong> 
   <small class="d-block text-center text-muted">{{$item->comments->count()}} comments</small>
   <div class="text-center">
        @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-block', 'limit' => true])
      <small class="text-muted">started {{$item->created_at->diffForHumans()}}</small>
      <div>
         @if(!$item->alreadyInvited($user))
         <form action="{{route('discussion.invite.users', [$item->id])}}" method="post">
            @csrf
            <input type="hidden" value="{{$user->id}}" name="users[]">
            <button class="btn btn-sm btn-secondary btn-block">invite</button>
         </form>
         @else
            <button class="btn btn-sm btn-default btn-block bg-white">Already invited</button>
         @endif
      </div>
   </div>
</div>

<tag-follow-btn v-bind:prop_tag="{{$tag}}"></tag-follow-btn>
{{-- 
@auth
    <form action="{{route('tag.follow', [$tag->id])}}" class="tag-follow" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm {{Auth::user()->isFollowing($tag) ? 'btn-default' : 'btn-theme'}} ml-auto" data-role="{{Auth::user()->isFollowing($tag) ? 'unfollow' : 'follow'}}"><i class="fa {{Auth::user()->isFollowing($tag) ? 'fa-minus-circle' : 'fa-plus-circle'}} icon"></i> <span class="text">{{Auth::user()->isFollowing($tag) ? 'unfollow' : 'follow'}}</span></button>
    </form>
@endauth

@guest
    <form action="{{route('tag.follow', [$tag->id])}}" class="tag-follow" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-theme ml-auto float-right" data-role="follow"><i class="fa fa-plus-circle icon"></i> <span class="text"> follow</span></button>
    </form>
@endguest --}}


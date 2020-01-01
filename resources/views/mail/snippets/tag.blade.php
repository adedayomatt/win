<a href="{{route('tag.show',$tag->slug)}}" class="tag">#{{$tag->name}}</a>
@if($tag->description != null)
    <small class="text-muted">{{$tag->description}}</small>
@endif
<div>
    @if($tag->users->count() > 0)
    <small class="d-block text-muted">followed by </small>
       @include('mail.widgets.users-tile',['users' => $tag->users, 'max' => 5])
    @else
        <small class="text-muted">No followers yet</small>
    @endif
</div>

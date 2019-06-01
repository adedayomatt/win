<div class="item">
    <a href="{{route('discussion.show',[$item->slug])}}"><strong>{{$item->title}}</strong></a>
    <div class="text-muted text-center">
        <small>in <a href="{{route('forum.show',[$item->forum->slug])}}">{{$item->forum->name}}</a></small>
    </div>
    <div style="border-top: 1px solid #f2f2f2" class="pt-1">
        <div class="small text-muted">participating</div>
         @include('discussion.widgets.contributors-mini',['discussion' => $item])
    </div>
</div>
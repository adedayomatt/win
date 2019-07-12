<div class="item">
    @include('user.widgets.snippet',['user' => $item,'display' => 'd-block'])
    <div class="text-muted text-right">
        <small>joined {{$item->created_at->diffForHumans()}}</small>
    </div>
</div>
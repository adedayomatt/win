<div class="item">
    @include('user.widgets.snippet',['user' => $item->user,'display' => 'd-block', 'limit' => true])
    <div class="text-muted text-center">
        <small>started {{$item->discussions}} discussions</small>
    </div>
</div>
<div class="snippet">
    <div class="">
        <div class="card-title">
            <strong>{{$discussion->title}}</strong>
            <div class="pl-2">
                @include('discussion.widgets.meta')
            </div>
        </div>
        {!!$discussion->content()!!} 
        @if($discussion->fromPost())
            <?php $post = $discussion->post ?>
            <div class="ml-3">
                @include('post.widgets.snippet')
            </div>
        @endif
         <a href="{{route('discussion.show',[$discussion->slug])}}">see full discussion</a>
    </div>
    <?php $tags = $discussion->tags ?>
    @include('tag.widget-alt')
</div>

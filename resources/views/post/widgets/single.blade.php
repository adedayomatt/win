<div class="list-group-item border-0">
    <div class="mb-2">
        @if($post->coverAvailable())
            <img src="{{$post->cover()['src']}}" alt="{{$post->cover()['alt']}}" width="100%">
        @endif
        <div>
            <h6><a href="{{route('post.show',[$post->slug])}}">{{$post->title}}</a></h6>
            @include('post.widgets.meta')
        </div>
    </div>
    <div class="mt-2">
        {!! $post->content() !!}
        <?php $tags = $post->tags ?>
        @include('tag.widget-alt')


    </div>
</div>
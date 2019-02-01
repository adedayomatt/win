<div class="snippet">
    <div class="">
        <img src="{{$post->cover()['src']}}" alt="{{$post->cover()['alt']}}" width="100%">
    </div>
    <div class="">
        <div class="card-title">
            <div>
                <a href="{{route('post.show',$post->slug)}}"><h6>{{$post->title}}</h6></a>
                <div class="ml-2">
                @include('post.widgets.meta')
                </div>
            </div>
        </div>
        {!!$post->content()!!} 
        <a href="{{route('post.show',[$post->slug])}}">see full post</a>
    </div>
    <?php $tags = $post->tags ?>
    @include('tag.widget-alt')

</div>

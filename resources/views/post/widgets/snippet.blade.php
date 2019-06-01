<div class="snippet row row-eq-height">
    <div class="col-4" style="background-image: url('{{$post->cover()['src']}}'); background-size: cover; background-repeat: no-repeat">
        <img class="d-none" src="{{$post->cover()['src']}}" alt="{{$post->cover()['alt']}}" width="100%">
    </div>
    <div class="col-8">
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
    @include('tag.widgets.inline',['tags'=> $post->tags])
</div>

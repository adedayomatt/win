<div class="list-group-item list-group-item-action flex-column align-items-start" >
    <div class="d-flex w-100">
        <img src="{{$post->cover()['src']}}" alt="{{$post->cover()['alt']}}" class="post-cover">
        <div>
            <h5>{{$post->name}}</h5>
            <a href="{{route('post.show',[$post->slug])}}">{{$post->slug}}</a>
        </div>
    </div>
    <div class="mb-1">
        <div class="description-container">
                {!! $post->content() !!}
        </div>
    </div>
    <small class="ml-3"><a href="{{route('post.category.show',$post->category->slug)}}">{{$post->category->name}}</a></small>
    <small class="grey"><i class="fa fa-user"></i> posted by {{$post->user->fullname()}}</small>
</div>
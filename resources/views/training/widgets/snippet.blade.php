<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col-2 text-center">
                <img src="{{$post->avatar()['src']}}" alt="{{$post->avatar()['alt']}}" class="avatar avatar-sm">
            </div>
            <div class="col-10">
                <h4>{{$post->name}}</h4>
                @include('post.widgets.operations.edit')
            </div>
        </div>        
    </div>
    <div class="card-body">
        <p class="text-center">
            {!!$post->body!!}
        </p>
    </div>
</div>

@if($post->discussions->count() > 0)
    @foreach($post->discussions as $discussion)
        @include('discussion.widgets.snippet')
    @endforeach
@else
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="alert alert-info">
                No discussion on <strong>{{$post->title}}</strong> yet
            </div>
        </div>
    </div>
@endif
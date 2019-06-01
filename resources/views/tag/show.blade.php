@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="content-box">
        <div class="d-flex">
            <h5>{{$tag->name}}</h5>
            @if($tag->following(Auth::id()))
                <a href="{{route('tag.unfollow',[$tag->slug])}}" class="btn btn-sm btn-primary ml-auto"><i class="fa fa-minus"></i> unfollow</a>
            @else
                <a href="{{route('tag.follow',[$tag->slug])}}" class="btn btn-sm btn-primary ml-auto"><i class="fa fa-plus"></i> follow</a>
            @endif
        </div>
        <div class="text-muted">
            <p>{!!$tag->description!!}</p>
            <div>
                <span>{{number_format($tag->discussions->count())}} discussions</span>
                <span class="ml-2">{{number_format($tag->posts->count())}} posts</span>
            </div>
        </div>
    </div>
    <h6>Other tags </h6>
    @include('components.owl-carousel', ['carousel_collection' => $tag->otherTags()->take(10)->get(), 'carousel_template'=> 'tag.templates.carousel-default','carousel_layout' => ['xs' => 2, 'sm' => '2', 'md' => 2, 'lg' => 2]])
    @include('components.ads.sample')
@endsection


@section('main')

        <div class="content-box ">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="discussions-tab" data-toggle="tab" href="#discussions" role="tab" aria-controls="discussions" aria-selected="true">Discussions ({{$tag->discussions->count()}})</a>
                    <a class="nav-item nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">Posts ({{$tag->posts->count()}}) </a>
                </div>
            </nav>
            <div class="tab-content" id="discussions-posts-tab-content">
                <div class="tab-pane fade show active mt-2" id="discussions" role="tabpanel" aria-labelledby="discussions-tab">
                    @if($tag->discussions->count() > 0)
                        @foreach($tag->discussions as $discussion)
                                @include('discussion.widgets.snippet', ['discussion' => $discussion])
                        @endforeach
                    @else
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-muted">
                                <h5>No discussion in {{$tag->name}} yet</h5>
                                <a href="{{route('discussion.create')}}" class="btn btn-primary">Create one now</a>
                            </div>
                        </div>
                    @endif    
                </div>
                <div class="tab-pane fade mt-2" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                    @if($tag->posts->count() > 0)
                        @foreach($tag->posts as $post)
                                @include('post.widgets.snippet', ['post' => $post])
                        @endforeach
                    @else
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-muted">
                                <h5>No post in {{$tag->name}} yet</h5>
                                <a href="{{route('post.create')}}" class="btn btn-primary">Create one now</a>
                            </div>
                        </div>
                    @endif 
                </div>
            </div> 
        </div>
    
    
@endsection

@section('RHS')
    <div class="card">
        <div class="card-body">
            <h6>Followed by:</h6>
            @include('user.widgets.list', ['users_collection' => $tag->followers()])
        </div>
    </div>
    <h6>Trending</h6>
    @include('tag.widgets.trending', ['carousel_layout' => ['xs' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2] ])
@endsection



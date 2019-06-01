@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    @auth()
        <div class="content-box">
            @include('user.widgets.snippet',['user' => Auth::user()])
        </div>
        <h6>My Interests: </h6>
        <div class="content-box">
            @if(auth()->user()->tags->count() > 0)
                 @include('tag.widgets.inline', ['tags' => auth()->user()->tags])
            @else
                <span class="grey">You don't have any interest yet</span> <a href="{{route('create.interests',auth()->user()->username)}}">Add interests now</a>
            @endif
        </div>
       @include('components.ads.sample')
        <h6>People</h6>
        @include('components.owl-carousel', ['carousel_collection' => $_users::all() , 'carousel_template' => 'user.templates.carousel-default', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>2]])

    @endauth

    @guest()
        <h2 class="text-center">Built Just For You</h2>
        <div class="content-box ">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign in</a>
                    <a class="nav-item nav-link" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign up</a>
                </div>
            </nav>
            <div class="tab-content" id="signin-signup-tab-content">
                <div class="tab-pane fade show active mt-2" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                    @include('user.forms.login')
                </div>
                <div class="tab-pane fade mt-2" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                    @include('user.forms.register')
                </div>
            </div> 
        </div>
    @endguest
    
@endsection
@section('main')
    <h6>Trending</h6>
    @include('tag.widgets.trending', ['carousel_layout' => ['xs' => 2, 'sm' => 3, 'md' => 3, 'lg' => 3] ])
    @auth()
        <h6>Feeds</h6>
        @include('components.feeds._feeds')
    @endauth
    @guest()
        <h6>See what people are talking about</h6>
            @include('components.feeds.guest-feeds')
        <h5>Here are some interesting post you might like</h5>
            <div class="content-bo">
                @include('components.owl-carousel', ['carousel_collection' => $_posts::orderby('created_at', 'desc')->take(10)->get(), 'carousel_template' => 'post.templates.carousel-default', 'carousel_layout' => ['xs' => 2, 'sm' => 3, 'md' => 3, 'lg' => 3]])
            </div>
        <div class="text-right">
            <a href="{{route('post.index')}}">see more</a>
        </div>
    @endguest
  
@endsection
@section('RHS')
    <h6>Forums</h6>
    @include('components.owl-carousel', ['carousel_collection'=> $_forums::orderby('created_at','desc')->take(10)->get(), 'carousel_template'=>'forum.templates.carousel-default', 'carousel_layout' => ['xs' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2]])

    <h6>Tags</h6>
    <div class="content-box">
        @include('tag.widgets.list')
    </div>

    <h6>Top Contributors</h6>
    @if($top_contributors->count() > 0)
        @include('components.owl-carousel', ['carousel_collection' => $top_contributors , 'carousel_template' => 'discussion.templates.carousel-contributor', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>2]])
    @else
        <p class="text-muted text-center">Not available</p>
    @endif

    @guest()
        <!-- <div class="content-box text-center">
                <h4>Don't miss out of the conversations</h4>
                <a href="{{route('login')}}" class="btn btn-primary btn-block">Sign in</a>
                <a href="{{route('register')}}" class="btn btn-success btn-block">Sign up</a>
        </div> -->
    @endguest

    
@endsection

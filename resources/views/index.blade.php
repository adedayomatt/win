@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    @auth()
        <div class="content-box">
            @include('user.widgets.snippet',['user' => Auth::user()])
        </div>
        <h6>My Interests: </h6>
        <div style="max-height: 200px; overflow: auto">
            @if(auth()->user()->tagsFollowing->count() > 0)
                 @include('tag.widgets.inline', ['tags' => auth()->user()->tagsFollowing])
            @else
                <div class="text-muted p-2">
                    You don't have any interest yet <a href="{{route('user.settings',['user'=> auth()->user()->username,'tab' => 'interests'])}}">Add interests now</a>
                </div>
            @endif
        </div>
       @include('components.ads.sample')
       <h6>Forums</h6>
        @if($_forums::count() > 0)
            @include('components.owl-carousel', ['carousel_collection'=> $_forums::orderby('created_at','desc')->take(10)->get(), 'carousel_template'=>'forum.templates.carousel-default', 'carousel_layout' => ['xs' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2]])
            @if($_forums::count() > 10)
                <div class="text-right">
                    <a href="{{route('forum.index')}}">see more</a>
                </div>
            @endif
        @else
            <div class="content-box text-muted text-center">
                <small>No forum yet</small> 
            </div>
        @endif

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

    <feeds url="/feeds" ></feeds>
  
@endsection
@section('RHS')
    <div class="">
        @include('tag.widgets.list')
        <div class="text-right">
            <a href="{{route('tags')}}">All tags</a>
        </div>
    </div>
    @include('layouts.components.footer')


    
@endsection

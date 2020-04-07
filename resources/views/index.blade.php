@extends('layouts.appLHSfixedRHSfixed')
@section('title')
  Home
@endsection

@section('meta')
    <meta name="description" content="Online community to share experience on several topics all inside life!">
    <meta name="keywords" content="online, insydelife, discussion, community, experience, {{join(',',\App\Tag::trending()->pluck('name')->toArray()) }}">
    <meta property="og:title" content="InsydeLife" />
    <meta property="og:description" content="Online community to share experience on several topics all inside life!" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('home')}}" />
    <meta property="og:type" content="website" />
@endsection

@section('styles')
    @guest
        .lhs-fixed{
            {{-- background-color: {{primaryColor()}}; --}}
            min-height: 50vh;
            margin-top: -20px;
        }
        .lhs-content{
            padding-left: 10px;
            padding-right: 10px;
        }
        .lhs-content .tag-line{
            {{-- color: #fff !important --}}
        }
    @endguest
@endsection

@section('md-styles')
    @guest
        .lhs-fixed{
            min-height: 100vh;
        }
@endguest
@endsection
@section('LHS')
    @auth()
        <div class="content-box">
            @include('user.widgets.snippet',['user' => Auth::user()])
            <div class="text-center my-2">
                <a href="{{route('discussion.create')}}" class="btn btn-theme btn-sm m-1">
                    <i class="fa fa-plus"></i> Start a discussion
               </a>
               <a href="{{route('experience.create')}}" class="btn btn-theme btn-sm m-1">
                <i class="fa fa-share-alt"></i> Share an experience
               </a>
            </div>
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
    <div class="py-5">
        <h2 class="text-center tag-line">Your Story Could Inspire Us</h2>
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
    </div>
    @endguest
    
@endsection
@section('main')
    <div class="py-3">
        <h6>Most used tags</h6>    
        @include('tag.widgets.trending', ['carousel_layout' => ['xs' => 2, 'sm' => 3, 'md' => 3, 'lg' => 3] ])
        <div id="home-feeds-container">
            <feeds url="{{Auth::check() ? '/feeds' : '/recent-feeds'}}"></feeds>
        </div>
    </div>
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

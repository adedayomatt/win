@extends('layouts.appRHSfixed')

@section('title')
    @if ($user !== null)
        {{$user->fullname}} ({{$user->username()}})
    @else
        {{'@'.$username}}
    @endif
@endsection

@section('meta')
    @if ($user !== null)
        <meta name="description" content="{{$user->fullname()}} on insydelife. {{$user->educationStatus()}}. {{$user->workStatus()}}">
        <meta name="keywords" content="insydelife, discussion, experience, community, share, learning, forum, {{$user->hasEducation() ? $user->education->course.','.$user->education->school->name.',' : ''}}, {{$user->hasWork() ? $user->work->title.','. $user->work->company->name : ''}} ">
        <meta name="Author" content="{{$user->fullname()}}">
        <meta property="og:title" content="{{$user->fullname()}}" />
        <meta property="og:description" content="{{$user->fullname()}} on insydelife. {{$user->educationStatus()}}. {{$user->workStatus()}}" />
        <meta property="og:image" content="{{$user->avatar()['src']}}" />
        <meta property="og:url" content="{{route('user.profile',[$user->username])}}" />
        <meta property="og:type" content="website" />
    @else
        <meta name="Author" content="{{'@'.$username}}">
        <meta name="description" content="No user is found with this username">
        <meta property="og:image" content="{{asset('assets/user-default.png')}}" />
        <meta property="og:title" content="No user found" />
        <meta property="og:url" content="{{route('user.profile',[$username])}}" />
    @endif
@endsection

@section('styles')
    main{
        margin-top: 60px;
    }
    .generic-profile-bg{
        background-color: {{primaryColor()}};
        height: 150px;
    }
    .user-about-container{
        background-color: #fff;
    }
    #avatar{
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin-top: -100px;
    }


    #avatar-upload{
        overflow: hidden;
    }
    #avatar-upload input[type='file']{
        width: 100%;
        position: absolute;
        padding: 10px 0;
        width: 50px;
        left: 0;
        opacity: 0;
    }
    #avatar-upload div{
     
    }
    .profile-section{
        border: 1px solid #f2f2f2;
        margin-bottom: 3px;
    }
    .profile-section>.content-box{
        margin: 0;
        border-radius: 0;
    }
    .profile-section .collapse{
        padding: 5px;
    }
@endsection
@section('xs-styles')
    .no-padding-xs{
        padding: 0 !important;
    }
@endsection
@section('sm-styles')
.generic-profile-bg{
        height: 150px;
    }
    #avatar{
        width: 150px;
        height: 150px;
    }
@endsection

@section('main')
      
        <div class="row">
            <div class="col-12 no-padding-xs">
                <div class="generic-profile-bg">
                </div>
                <div class="user-about-container p-2" >
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <div class="">
                                @if ($user === null)
                                    <img id="avatar" src="{{asset('assets/user-default.png')}}">
                                @else
                                    <img id="avatar" src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}">
                                    @if($user->auth())
                                        <form action="{{route('update.avatar',[$user->username])}}" id="avatar-upload" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input  type="file" name="avatar" accept="image/*" onchange="javascript: document.querySelector('form#avatar-upload').submit()">
                                            <div class="text-center"><span class="operation" style="cursor: pointer"><i class="fa fa-camera" ></i></span></div>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-6 col-md-4 no-padding-xs">
                            <div class="">
                                @if ($user === null)
                                    <div class="mt-2">
                                        <h5>User Not Found</h5>
                                        <h6 class="text-muted">No user found</h6>
                                    </div>
                                @else
                                    @if($user->auth())
                                        <div class="float-right">
                                            <a href="{{route('user.settings',[$user->username])}}?tab=info" class="operation"><i class="fas fa-cog" title="edit"></i></a>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <h5>{{$user->fullname()}}</h5>
                                        <h6 class="text-muted">{{$user->username()}}</h6>
                                    </div>
                                    <div class="text-muted">
                                        <p>{{$user->bio}}</p>
                                    </div>
                                @endif                                        
                            </div>
                        </div>
                        @if ($user !== null)
                            <div class="col-md-4">
                                @if($user->hasEducation())
                                    <div class="py-1">
                                        <i class="fa fa-graduation-cap color-primary" style="font-size: 25px"></i> {{$user->educationStatus()}} 
                                        @if($user->auth())
                                            <a href="{{route('user.settings',[$user->username])}}?tab=education" class="operation"><i class="fas fa-pen" title="edit education"></i></a>
                                        @endif
                                    </div>
                                @else
                                    @if($user->auth())
                                        <div class="content-box">
                                            Add your current education to your profile, <a href="{{route('user.settings',[$user->username])}}?tab=education" class="operation"><i class="fa fa-plus"></i> add education</a>
                                        </div>
                                    @endif
                                @endif

                                @if($user->hasWork())
                                    <div class="py-1">
                                    <i class="fa fa-briefcase color-primary" style="font-size: 25px"></i> {{$user->workStatus()}} 
                                        <div class="text-muted">
                                            {{$user->work->job_description == null ? '' : $user->work->job_description }}
                                        </div>
                                    @if($user->auth())
                                            <a href="{{route('user.settings',[$user->username])}}?tab=work" class="operation"><i class="fas fa-pen" title="edit work"></i></a>
                                        @endif
                        
                                    </div>
                                
                                @else
                                    @if($user->auth())
                                        <div class="content-box">
                                            Let people know where you currently work, <a href="{{route('user.settings',[$user->username])}}?tab=work" class="operation"><i class="fa fa-plus"></i> add work to profile</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($user !== null)
                <div class="col-md-4 no-padding-xs">
                    <div class="mt-1">
                        @if($user->auth())
                            @if(!auth()->user()->emailVerified())
                                <div class="content-box">
                                    <div class="alert alert-warning">
                                        <i class="fa fa-exclamation-triangle"></i> {{auth()->user()->firstname}}, check your mailbox <strong>{{auth()->user()->email}}</strong> for verification link
                                    </div>
                                    Didn't receive any mail, <a href="{{ route('verification.resend') }}">click here to request another</a>
                                </div>
                            @endif
                        @endif
                        <div class="profile-container">
                            <div class="profile-section-container">
                                <div class="profile-section">
                                    <div class="content-box" data-toggle="collapse" data-target="#interests" aria-expanded="true">
                                        <div class="d-flex">
                                            <h6>Interest ({{$user->tagsFollowing->count()}})</h6>
                                            @if($user->auth())
                                                <div class="ml-auto">
                                                    <a href="{{route('user.settings',[$user->username])}}?tab=interests" class="operation"><i class="fas fa-pen" title="edit"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="collapse show" id="interests" data-parent="">
                                        @if($user->tagsFollowing->count()> 0)
                                            @include('tag.widgets.inline', ['tags' => $user->tagsFollowing ])
                                        @else
                                            <div class="text-muted text-center">
                                                No interest
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="profile-section">
                                    <div class="content-box" data-toggle="collapse" data-target="#experiences" aria-expanded="true">
                                        <div class="d-flex">
                                            <h6>Shared Experiences ({{$user->experiences->count()}})</h6>
                                            @if($user->auth())
                                                <div class="ml-auto">
                                                    <a href="{{route('experience.create')}}" class="operation"><i class="fas fa-plus" title="create new experience"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="collapse show" id="experiences" data-parent="">
                                        @if($user->experiences->count() > 0)
                                            @foreach($user->experiences()->orderby('created_at', 'desc')->take(3)->get() as $experience)
                                                <h6><a href="{{route('experience.show',[$experience->slug])}}">{{$experience->title}}</a></h6>
                                                <div class="text-muted">
                                                    <small class="m-1"><a href="{{route('experience.show',[$experience->slug])}}#discussions">{{$experience->discussions->count()}} discussions</a></small>
                                                    <small class="m-1">published {{$experience->created_at->diffForHumans()}}</small>
                                                </div>
                                                @if($experience->tags->count() > 0)
                                                    @foreach($experience->tags()->take(4)->get() as $tag)
                                                        <a href="{{route('tag.show',[$tag->slug])}}" class="tag">#{{$tag->name}}</a>
                                                    @endforeach
                                                    @if($experience->tags->count() > 4)
                                                        <small class="text-muted ml-2"> + {{$experience->tags->count() - 4}} other tags</small>
                                                    @endif
                                                @endif
                                                <hr>
                                            @endforeach
                                            <div class="text-muted text-right small">
                                            @if($user->experiences->count() > 3)
                                                + {{$user->experiences->count() - 2}} more. 
                                            @endif
                                            <a href="{{route('user.experiences',[$user->username])}}">all experiences</a>
                                            </div>
                                        @else
                                            <div class="text-muted text-center">
                                                No experience yet
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="profile-section">
                                    <div class="content-box" data-toggle="collapse" data-target="#forums" aria-expanded="true">
                                        <div class="d-flex">
                                            <h6>Forums ({{$user->forums->count()}})</h6>
                                            @if($user->auth())
                                                <div class="ml-auto">
                                                    <a href="{{route('forum.create')}}" class="operation"><i class="fas fa-plus" title="create new forum"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="collapse show" id="forums" data-parent="">
                                        @if($user->forums->count() > 0)
                                            @foreach($user->forums()->orderby('created_at', 'desc')->take(3)->get() as $forum)
                                                <h6><a href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a></h6>
                                                <div class="text-muted">
                                                    <small class="m-1">{{$forum->discussions->count()}} discussions</a></small>
                                                    <small class="m-1">created {{$forum->created_at->diffForHumans()}}</a></small>
                                                </div>
                                                <hr>
                                            @endforeach
                                            <div class="text-muted text-right small">
                                                @if($user->forums->count() > 3)
                                                    + {{$user->forums->count() - 3}} more. 
                                                @endif
                                                <a href="{{route('user.forums',[$user->username])}}">all forums</a>
                                            </div>
                                            
                                        @else
                                            <div class="text-muted text-center">
                                                No forum created yet
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="profile-section">
                                    <div class="content-box" data-toggle="collapse" data-target="#discussions-started" aria-expanded="true">
                                        <div class="d-flex">
                                            <h6>Discussion started ({{$user->discussions->count()}})</h6>
                                            @if($user->auth())
                                                <div class="ml-auto">
                                                    <a href="{{route('discussion.create')}}" class="operation"><i class="fas fa-plus" title="create new discussion"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="collapse show" id="discussions-started" data-parent="">
                                        @if($user->discussions->count() > 0)
                                            @foreach($user->discussions()->orderby('created_at', 'desc')->take(3)->get() as $discussion)
                                                <h6><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></h6>
                                                <div class="text-muted">
                                                    <small class="m-1"> in <a href="{{route('forum.show',$discussion->forum->slug)}}">{{$discussion->forum->name}}</a></small>
                                                    <small class="m-1"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$discussion->comments->count()}} comments </a></small>
                                                    <small class="m-1">started {{$discussion->created_at->diffForHumans()}}</small>
                                                </div>
                                                @if($discussion->tags->count() > 0)
                                                    @foreach($discussion->tags()->take(4)->get() as $tag)
                                                        <a href="{{route('tag.show',[$tag->slug])}}" class="tag">{{$tag->name}}</a>
                                                    @endforeach
                                                    @if($discussion->tags->count() > 4)
                                                        <small class="text-muted ml-2"> + {{$discussion->tags->count() - 4}} other tags</small>
                                                    @endif
                                                @endif
                                                <hr>
                                            @endforeach
                                            <div class="text-muted text-right small">
                                                @if($user->discussions->count() > 3)
                                                    + {{$user->discussions->count() - 3}} more. 
                                                @endif
                                                <a href="{{route('user.discussions',[$user->username])}}">all discussions</a>
                                            </div>
                                        @else
                                            <div class="text-muted text-center">
                                                No discussion started yet
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="profile-section">
                                    <div class="profile-section content-box" data-toggle="collapse" data-target="#discussions-contributions" aria-expanded="true">
                                        <div class="d-flex">
                                            <h6>Discussion contributed ({{$user->discussionContributions()->count()}})</h6>
                                        </div>
                                    </div>

                                    <div class="collapse show" id="discussions-contributions" data-parent="">
                                        @if($user->discussionContributions()->count() > 0)
                                            @foreach($user->discussionContributions($raw = true)->take(3)->get() as $contribution)
                                                <?php $discussion = $contribution->discussion();  ?>
                                                @if(!$discussion->isTrashed())
                                                    <h6><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></h6>
                                                    <div class="text-muted">
                                                        <small class="m-1"> in <a href="{{route('forum.show',$discussion->forum->slug)}}">{{$discussion->forum->name}}</a></small>
                                                        <small class="m-1"> started by <a href="{{route('user.profile',[$discussion->user->username])}}">{{$discussion->user->username()}}</a> {{$discussion->created_at->diffForHumans()}}</small>
                                                        <small class="m-1"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$contribution->total_comments}} contributions </a></small>
                                                        <small class="m-1"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$discussion->comments->count()}} total comments </a></small>
                                                    </div>
                                                @else
                                                    <h6 class="text-muted" data-toggle="tooltip" title="discussion deleted">{{$discussion->title}}</h6>
                                                @endif
                                                
                                                @if($discussion->tags->count() > 0)
                                                    @foreach($discussion->tags()->take(4)->get() as $tag)
                                                        <a href="{{route('tag.show',[$tag->slug])}}" class="tag">{{$tag->name}}</a>
                                                    @endforeach
                                                    @if($discussion->tags->count() > 4)
                                                        <small class="text-muted ml-2"> + {{$discussion->tags->count() - 4}} other tags</small>
                                                    @endif
                                                @endif
                                                <hr>
                                            @endforeach
                                            <div class="text-muted text-right small">
                                                @if($user->discussionContributions()->count() > 3)
                                                    + {{$user->discussionContributions()->count() - 3}} more. 
                                                @endif
                                                <a href="{{route('user.contributions',[$user->username])}}">all contributions</a>
                                            </div>
                                        @else
                                            <div class="text-muted text-center">
                                                Not contributing to any discussion
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 no-padding-xs">
                    @if($user->auth())               
                        <h6>Experiences in your interests</h6>
                            @if($user->interestedExperiences()->count() > 0)
                                @include('components.owl-carousel', ['carousel_collection' => $user->interestedExperiences(), 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3], 'carousel_template' => 'experience.templates.carousel-default'])
                            @else
                                <div class="content-box">
                                    <p class="text-muted text-center">No experience found</p>
                                </div>
                            @endif
                    @else
                        <!-- @auth
                            <h6>Invite {{$user->firstname}} to your discussions</h6>
                            @if(Auth::user()->discussions->count() > 0)
                                <div class="content-box">
                                    @include('components.owl-carousel', ['carousel_collection' => Auth::user()->discussions, 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3], 'carousel_template' => 'discussion.templates.carousel-invite', 'user' => $user])
                                </div>
                            @else
                                <div class="content-box text-muted text-center">
                                    <i class="fa fa-exclamation-triangle"></i> But you haven't started any discussion yet
                                </div>
                            @endif
                        @endauth -->
                    @endif

                    <div class="">
                        <div id="activities" class="anchor"></div>
                        <div class="text-muted text-center">
                            <strong>Activities</strong>
                        </div>
                        {{-- @include('components.feeds._feeds',['feeds' => $feeds]) --}}
                    <feeds url="/{{$user->username}}/feeds"></feeds>
                    </div>
                </div>
            @endif
        </div>

@endsection

@section('RHS')
    @if ($user !== null)
        @if($user->auth())
        <h6></h6> 
        @endif
        <div id="contributions" class="anchor"></div>
        <h6>Contributions ({{$user->discussionContributions()->sum('total_comments')}})</h6>
        @if($user->discussionContributions()->count() > 0)
            <div class="content-bo">
                <div class="list-group">
                    @foreach($user->discussionContributions($raw = true)->take(3)->get() as $contribution)
                        <div class="content-box">
                            @include('discussion.templates.list', ['discussion' => $contribution->discussion()])
                            @if(!$contribution->discussion()->isTrashed())
                                <div class="text-right text-muted">
                                    <p>contributed <a href="{{route('discussion.show', [$contribution->discussion()->slug])}}?contributor={{$user->username}}">{{$contribution->total_comments}} comments</a></p>
                                </div>
                            @else
                                <p class="text-muted">contributed {{$contribution->total_comments}} comments</p>
                            @endif
                        </div>
                    @endforeach 
                 </div>
            </div>
            @if($user->discussionContributions()->count() > 3)
                <div class="text-right">
                    <a href="{{route('user.contributions',[$user->username])}}">  + {{$user->discussionContributions()->count() - 3}} more
                </div>
            @endif</a>
        @else
            @if($user->auth())
                <div class="content-box">
                <p class="text-center text-muted">You have not made any contributions yet. Here are some suggestions</p> 

                @if($user->interestedDiscussions()->count() > 0)
                    @include('discussion.widgets.list', ['w_collection' => $user->interestedDiscussions()])
                @else
                    <div class="text-muted text-center">
                        <h1 class="fa fa-exclamation-triangle"></h1>
                        <p>No suggestion</p>
                    </div>
                @endif
                </div>
                    
            @else
                <div class="text-muted content-box">
                    No contribution by {{$user->firstname}}
                </div>
            @endif
        @endif
    @endif
@endsection
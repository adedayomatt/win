@extends('layouts.appRHSfixed')
@section('styles')
    .generic-profile-bg{
        background-color: {{primaryColor()}};
        height: 200px;
    }
    .user-about-container{
        background-color: #fff;
    }
    #avatar{
        width: 200px;
        height: 200px;
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
                <div class="generic-profile-bg"></div>
                        <div class="user-about-container p-2" >
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <div class="">
                                        <img id="avatar" src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}">
                                        @if($user->auth())
                                            <form action="{{route('update.avatar',[$user->username])}}" id="avatar-upload" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input  type="file" name="avatar" accept="image/*" onchange="javascript: document.querySelector('form#avatar-upload').submit()">
                                                <div class="text-center"><span class="operation" style="cursor: pointer"><i class="fa fa-camera" ></i></span></div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 no-padding-xs">
                                    <div class="">
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
                                    </div>
                                </div>
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
                            </div>
                        </div>

            </div>
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
                                <div class="collapse" id="interests" data-parent="">
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
                                <div class="content-box" data-toggle="collapse" data-target="#trainings" aria-expanded="true">
                                    <div class="d-flex">
                                        <h6>Published Trainings ({{$user->trainings->count()}})</h6>
                                        @if($user->auth())
                                            <div class="ml-auto">
                                                <a href="{{route('training.create')}}" class="operation"><i class="fas fa-plus" title="create new training"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="collapse" id="trainings" data-parent="">
                                    @if($user->trainings->count() > 0)
                                        @foreach($user->trainings()->orderby('created_at', 'desc')->take(3)->get() as $training)
                                            <h6><a href="{{route('training.show',[$training->slug])}}">{{$training->title}}</a></h6>
                                            <div class="text-muted">
                                                <small class="m-1"><a href="{{route('training.show',[$training->slug])}}#discussions">{{$training->discussions->count()}} discussions</a></small>
                                                <small class="m-1">published {{$training->created_at->diffForHumans()}}</small>
                                            </div>
                                            @if($training->tags->count() > 0)
                                                @foreach($training->tags()->take(4)->get() as $tag)
                                                    <a href="{{route('tag.show',[$tag->slug])}}" class="tag">#{{$tag->name}}</a>
                                                @endforeach
                                                @if($training->tags->count() > 4)
                                                    <small class="text-muted ml-2"> + {{$training->tags->count() - 4}} other tags</small>
                                                @endif
                                            @endif
                                            <hr>
                                        @endforeach
                                        @if($user->trainings->count() > 3)
                                            <div class="text-muted text-right">
                                                + <a href="{{route('user.trainings',[$user->username])}}">{{$user->trainings->count() - 2}} more</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-muted text-center">
                                            No training yet
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

                                <div class="collapse" id="forums" data-parent="">
                                    @if($user->forums->count() > 0)
                                        @foreach($user->forums()->orderby('created_at', 'desc')->take(3)->get() as $forum)
                                            <h6><a href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a></h6>
                                            <div class="text-muted">
                                                <small class="m-1">{{$forum->discussions->count()}} discussions</a></small>
                                                <small class="m-1">created {{$forum->created_at->diffForHumans()}}</a></small>
                                            </div>
                                            <hr>
                                        @endforeach
                                        @if($user->forums->count() > 3)
                                            <div class="text-muted text-right">
                                             + <a href="{{route('user.forums',[$user->username])}}">{{$user->forums->count() - 3}} more</a>
                                            </div>
                                        @endif
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

                                <div class="collapse" id="discussions-started" data-parent="">
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
                                        @if($user->discussions->count() > 3)
                                            <div class="text-muted text-right">
                                                + <a href="{{route('user.discussions',[$user->username])}}">{{$user->discussions->count() - 3}} more</a>
                                            </div>
                                        @endif
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

                                <div class="collapse" id="discussions-contributions" data-parent="">
                                    @if($user->discussionContributions()->count() > 0)
                                        @foreach($user->discussionContributions($raw = true)->take(3)->get() as $contribution)
                                            <?php $discussion = $contribution->discussion();  ?>
                                            @if(!$discussion->isTrashed())
                                                <h6><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></h6>
                                            @else
                                                <h6 class="text-muted" data-toggle="tooltip" title="discussion deleted">{{$discussion->title}}</h6>
                                            @endif
                                            <div class="text-muted">
                                                <small class="m-1"> in <a href="{{route('forum.show',$discussion->forum->slug)}}">{{$discussion->forum->name}}</a></small>
                                                <small class="m-1"> started by <a href="{{route('user.profile',[$discussion->user->username])}}">{{$discussion->user->username()}}</a> {{$discussion->created_at->diffForHumans()}}</small>
                                                <small class="m-1"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$contribution->total_comments}} contributions </a></small>
                                                <small class="m-1"><a href="{{route('discussion.show',[$discussion->slug])}}#comments">{{$discussion->comments->count()}} total comments </a></small>
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
                                        @if($user->discussionContributions()->count() > 3)
                                            <div class="text-muted text-right">
                                                + <a href="{{route('user.contributions',[$user->username])}}">{{$user->discussionContributions()->count() - 3}} more</a>
                                            </div>
                                        @endif
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
                    <h6>Training in your interests</h6>
                        @if($user->interestedTrainings()->count() > 0)
                            @include('components.owl-carousel', ['carousel_collection' => $user->interestedTrainings(), 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3], 'carousel_template' => 'training.templates.carousel-default'])
                        @else
                            <div class="content-box">
                                <p class="text-muted text-center">No training found</p>
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
                    @include('components.feeds._feeds',['feeds' => $feeds])
                </div>
            </div>
        </div>

@endsection

@section('RHS')
    @if($user->auth())
       <h6></h6> 
    @endif
    <div id="contributions" class="anchor"></div>
    <h6>Contributions ({{$user->discussionContributions()->sum('total_comments')}})</h6>
            @if($user->discussionContributions()->count() > 0)
            <div class="content-box">
                <div class="list-group">
                    @foreach($user->discussionContributions($raw = true)->take(3)->get() as $contribution)
                        <div class="contnt-box">
                            @include('discussion.templates.list', ['discussion' => $contribution->discussion()])
                            <div class="text-right text-muted">
                                <p>contributed {{$contribution->total_comments}} comments</p>
                            </div>
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
@endsection
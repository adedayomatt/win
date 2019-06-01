@extends('layouts.appLHSfixedRHSfixed')
@section('styles')
    .generic-profile-bg{
        background-color: grey;
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

@section('LHS')
    <div class="">
        <div class="profile-container">
            <div class="generic-profile-bg"></div>
            <div class="user-about-container p-2" >
                <div class="row justify-content-center">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <div class="text-center">
                            <img id="avatar" src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}">
                        </div>
                    </div>
                    <div class="col-2" style="padding: 0;overflow: hidden">
                        @if($user->auth())
                            <form action="{{route('update.avatar',[$user->username])}}" id="avatar-upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input  type="file" name="avatar" accept="image/*" onchange="javascript: document.querySelector('form#avatar-upload').submit()">
                                <div class="text-center"><i class="fa fa-camera" style="font-size: 30px; cursor: pointer"></i> change</div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="text-center">
                    <div class="mt-2">
                        <h6>{{$user->fullname()}}</h6>
                        {{$user->username()}}
                    </div>
                    <div class="grey">
                        {{$user->bio}}
                    </div>
                    @if($user->auth())
                        <div class="text-right">
                            <small><a href="{{route('user.settings',[$user->username])}}?tab=info"><i class="fas fa-cog" title="edit"></i> edit</a></small>
                        </div>
                    @endif
                </div>
            </div>
            <h6>Interest: </h6>
            <div class="content-box">
                @if($user->tags->count()> 0)
                    @include('tag.widgets.inline', ['tags' => $user->tags ])
                    @if($user->auth())
                    <div class="text-right">
                            <small><a href="{{route('user.settings',[$user->username])}}?tab=interests"><i class="fas fa-pen" title="edit"></i></a></small>
                        </div>
                    @endif
                @else
                    <span class="grey">No interest</span>
                    @if($user->auth())
                        <a href="{{route('add.interests',[$user->username])}}">Add interest</a>
                    @endif
                @endif
            </div>
           
        </div>
    </div>
@endsection
@section('main')
<div id="discussions" class="anchor"></div>
        <h6>Discussions</h6>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="initiated-discussions-tab" data-toggle="tab" href="#initiated-discussions" role="tab" aria-controls="initiated-discussions" aria-selected="true">initiated ({{$user->discussions->count()}})</a>
                <a class="nav-item nav-link" id="contributing-discussions-tab" data-toggle="tab" href="#contributing-discussions" role="tab" aria-controls="contributing-discussions" aria-selected="true">contributing ({{$user->discussionContributions()->count()}})</a>
                @if($user->auth())
                    <a class="nav-item nav-link" id="invited-discussions-tab" data-toggle="tab" href="#invitations" role="tab" aria-controls="invitations" aria-selected="false">Invitations ({{$user->discussionInvitations()->count()}}) </a>
                @endif
            </div>
        </nav>
        <div class="tab-content" id="discussions-tab-content">
            <div class="tab-pane fade show active mt-2" id="initiated-discussions" role="tabpanel" aria-labelledby="initiated-discussions-tab">
                @if($user->discussions->count() > 0)
                    @include('components.owl-carousel', ['carousel_collection' => $user->discussions, 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>3,'lg'=>3], 'carousel_template' => 'user.templates.carousel-discussion'])
                @else
                    <div class="content-box text-center">
                        <small class="text-muted ">
                            No discussion started yet
                        </small>
                        @if($user->auth())    
                            <a href="{{route('discussion.create')}}" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i> start a discussion</a>
                        @endif
                    </div>
                   
                @endif    
            </div>

            <div class="tab-pane fade mt-2" id="contributing-discussions" role="tabpanel" aria-labelledby="contributing-discussions-tab">
                @if($user->activeDiscussions()->count() > 0)
                    @include('components.owl-carousel', ['carousel_collection' => $user->activeDiscussions(), 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>3,'lg'=>3], 'carousel_template' => 'discussion.templates.carousel-default'])
                @else
                    <div class="content-box text-center">
                        <small class="text-muted ">
                            No contribution yet
                        </small>
                        <a href="{{route('discussion.index')}}" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i> start contributing</a>
                    </div>
                   
                @endif    
            </div>
            @if($user->auth())
                <div class="tab-pane fade mt-2" id="invitations" role="tabpanel" aria-labelledby="invited-discussions-tab">
                @if($user->discussionInvitations->count() > 0)
                        @include('components.owl-carousel', ['carousel_collection' => $user->discussionInvitations, 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>3,'lg'=>3], 'carousel_template' => 'discussion.templates.carousel-invitation'])
                    @else
                        <div class="content-box text-center">
                            <small class="text-muted">You have no invitation yet</small>
                        </div>
                    @endif 
                </div>
            @endif
        </div> 

    <div class="">
        <div id="activities" class="anchor"></div>
        <div class="content-box">
            <h5>Activities</h5>
        </div>
        @include('components.feeds._feeds',['feeds' => $feeds])
        @if($user->auth())
            <h6>Posts in your interests</h6>
            <div class="content-box">
                @if($user->interestedPosts()->count() > 0)
                    @include('components.owl-carousel', ['carousel_collection' => $user->interestedPosts(), 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3], 'carousel_template' => 'post.templates.carousel-default'])
                @else
                    <p class="text-muted text-center">No post found</p>
                @endif
            </div>
        @else
            @auth
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
            @endauth
        @endif
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
                    @foreach($user->discussionContributions() as $contribution)
                        <div class="contnt-box">
                            @include('discussion.templates.list', ['discussion' => $contribution->discussion])
                            <div class="text-right text-muted">
                                <p>contributed {{$contribution->total_comments}} comments</p>
                            </div>
                        </div>
                    @endforeach 
                 </div>
            </div>
               
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
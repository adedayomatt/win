@extends('layouts.appLHSfixed')
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
                                <div class="text-center"><i class="fa fa-camera" style="font-size: 30px; cursor: pointer"></i></div>
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
                            <small><a href="{{route('user.settings',[$user->username])}}?tab=info"><i class="fas fa-cog" title="edit"></i></a></small>
                        </div>
                    @endif
                </div>
            </div>
            <strong>Interest: </strong>
            @if($user->tags->count()> 0)
                <?php $tags = $user->tags ?>
                @include('tag.widget-alt')
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
@endsection
@section('main')
    <div class="conteiner">
        <div class="content-box">
            <h5>Activities</h5>
        </div>
        @include('components.feeds._feeds')
    </div>
@endsection

@section('RHS')

@endsection
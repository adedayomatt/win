@extends('layouts.appLHSfixed')
@section('styles')
    .generic-profile-bg{
        background-color: grey;
        height: 200px;
    }
    .user-about-container{
        background-color: #fff;
    }
    .user-about-container img{
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin-top: -100px;
    }
@endsection

@section('sm-styles')
.generic-profile-bg{
        height: 150px;
    }

    .user-about-container img{
        width: 150px;
        height: 150px;
    }
@endsection

@section('LHS')
    <div class="">
        <div class="profile-container">
            <div class="generic-profile-bg"></div>
            <div class="user-about-container p-2">
                <div class="text-center">
                    <img src="{{$user->avatar()['src']}}" alt="{{$user->avatar()['alt']}}">
                    <div class="mt-3">
                        <h6>{{$user->fullname()}}</h6>
                        {{$user->username()}}
                    </div>
                </div>
                <div>
                    <strong>Interest: </strong>
                    @if($user->tags->count()> 0)
                        <?php $tags = $user->tags ?>
                        @include('tag.widget-alt')
                        @if($user->auth())
                        <br>
                            <a href="{{route('edit.interests',[$user->username])}}">edit interest</a>
                        @endif
                    @else
                        <span class="grey">No interest selected</span>
                        @if($user->auth())
                            <a href="{{route('add.interests',[$user->username])}}">Add interest</a>
                        @endif
                    @endif
                </div>
            </div>
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
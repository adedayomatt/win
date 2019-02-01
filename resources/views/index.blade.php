@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    @auth()
        <?php
        $user = Auth::user();
        ?>
        <div class="content-box">
            @include('user.widgets.snippet')
        </div>
        <div class="content-box">
            <strong>How is going today {{$user->firstname}} ?</strong>
            <div class="text-center mt-3">
                <a href="{{route('forum.create')}}" class="btn btn-sm btn-secondary">New Forum</a>
                <a href="{{route('discussion.create')}}" class="btn btn-sm btn-secondary">New Discussion</a>
            </div>
        </div>
        <div class="content-box">
            My Interests: 
            @if(auth()->user()->tags->count() > 0)
                <?php $tags = auth()->user()->tags ?>
                 @include('tag.widget-alt')
            @else
                <span class="grey">You don't have any interest yet</span> <a href="{{route('create.interests',auth()->user()->username)}}">Add interests now</a>
            @endif
        </div>
    @endauth
    @guest()
        <div class="content-box">
            <h1>WHAT ARE YOU WAITING GOR</h1>
        </div>
    @endguest
    
@endsection
@section('main')
    <div class="content-box">
        <h5>Feeds</h5>
    </div>
    @include('components.feeds._feeds')
    @auth()

    @endauth

    @guest()
    @endguest
  
@endsection
@section('RHS')
    @include('tag.widget')
    @guest()
        <div class="content-box text-center">
                <h4>Don't miss out of the conversations</h4>
                <a href="{{route('login')}}" class="btn btn-primary btn-block">Sign in</a>
                <a href="{{route('register')}}" class="btn btn-success btn-block">Sign up</a>

        </div>
    @endguest
    @auth()
        @include('forum.widgets.list')
    @endauth
@endsection

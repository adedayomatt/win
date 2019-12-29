@extends('layouts.plain')

@section('title')
  {{$user->fullname}} ({{$user->username()}}) | Interests
@endsection

@section('styles')
    body{
        background-color: #F5F8FA;
    }
@endsection

@section('main')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-8">
            <form action="{{route('add.interests',[$user->username])}}" method="POST">
                @csrf    
                <div class="content-box ">
                    <div style="padding: 40px 0">
                        @include('user.widgets.snippet')
                        <div class="py-2">
                            @if(isNewUser())
                                <p class="text-muted">We are so glad to have you join this community, <strong>{{$user->firstname}}</strong></p>
                                <h5>Just one more thing</h5>
                            @endif
                            <p>Select tags to follow. We'll use this to customize what you see on your feeds</p>
                        </div>
                        @if($user)
                            <tag-suggest></tag-suggest>
                        @endif
                        <hr>
                        <p class="text-center">But it's okay if you want to skip this</p>
                        <div class="text-right">
                            <a href="{{route('home')}}" class="btn btn-theme">skip</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

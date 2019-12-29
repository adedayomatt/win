@extends('layouts.plain')
@section('title')
    Sign up
@endsection

@section('styles')
    body{
        background-color: #F5F8FA;
    }
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-6">
            <div class="content-box">
                <div class="text-center">
                    <h4>Sign up</h4>
                    <p>Already have an account? <a href="{{route('login')}}">Sign in</a></p>
                </div>
                <div class="">
                    @include('user.forms.register')
                </div>
            </div>
        </div>
    </div>
@endsection

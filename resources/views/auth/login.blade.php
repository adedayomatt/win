@extends('layouts.plain')

@section('title')
    Sign in
@endsection

@section('styles')
    body{
        background-color: #F5F8FA;
    }
@endsection

@section('main')
<div class="mt-50">
    <div class="row justify-content-center">
        <div class="col-md-3 col-sm-4">
            <div class="content-box">
                <div>
                    <div class="text-center">
                        <h4>Sign in</h4>
                        <p>Don't have an account yet? <a href="{{route('register')}}">Sign up now</a></p>
                    </div>
                    <div class="mt-10">
                        @include('user.forms.login')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

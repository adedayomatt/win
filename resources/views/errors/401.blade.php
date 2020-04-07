@extends('layouts.appError')

@section('title', __('Unauthorized'))
@section('meta')
    <meta name="description" content="You are not authorized to view the resource">
    <meta property="og:title" content="Unauthorized" />
    <meta property="og:description" content="You are not authorized to view the resource" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">You are not authorized for that resource</h4>
                <a href="{{route('login')}}">Login</a> or <a href="{{route('register')}}">Sign up</a>
            </div>
            <div class="mt-3">
                <a href="{{route('home')}}" class="btn btn-primary">Go Home</a>
            </div>
        </div>
   </div>
@endsection

@extends('layouts.appError')

@section('title', __('Forbidden'))
@section('meta')
    <meta name="description" content="Sorry, you are forbidden from accessing this page">
    <meta property="og:title" content="Forbidden" />
    <meta property="og:description" content="Sorry, you are forbidden from accessing this page" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">Sorry, you are forbidden from accessing this page</h4>
            </div>
            <div class="mt-3">
                <a href="{{route('home')}}" class="btn btn-primary">Go Home</a>
            </div>
        </div>
   </div>
@endsection

@extends('layouts.appError')

@section('title', __('Too Many Requests'))
@section('meta')
    <meta name="description" content="Sorry, you are making too many requests to our servers.">
    <meta property="og:title" content="Too Many Requests" />
    <meta property="og:description" content="Sorry, you are making too many requests to our servers." />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">Sorry, you are making too many requests to our servers.</h4>
                <div class="mt-3">
                    <a href="{{route('home')}}" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
   </div>
@endsection

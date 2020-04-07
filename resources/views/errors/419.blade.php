@extends('layouts.appError')

@section('title', __('Page Expired'))
@section('meta')
    <meta name="description" content="Sorry, your session has expired. Please refresh and try again.">
    <meta property="og:title" content="Forbidden" />
    <meta property="og:description" content="Sorry, your session has expired. Please refresh and try again." />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">Sorry, your session has expired. Please refresh and try again.</h4>
                <div class="mt-3">
                    <a href="{{route('home')}}" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
   </div>
@endsection

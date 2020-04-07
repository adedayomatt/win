@extends('layouts.appError')

@section('title', __('Service Unavailable'))
@section('meta')
    <meta name="description" content="Not available at the moment<">
    <meta property="og:title" content="Service Unavailable" />
    <meta property="og:description" content="Not available at the moment<" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">Not available at the moment</h4>
                <div class="mt-3">
                    <a href="{{route('home')}}" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
   </div>
@endsection

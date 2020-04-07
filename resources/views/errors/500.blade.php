@extends('layouts.appError')

@section('title', __('Error'))
@section('meta')
    <meta name="description" content="Whoops, something went wrong on our servers.">
    <meta property="og:title" content="Error" />
    <meta property="og:description" content="Whoops, something went wrong on our servers" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h4 class="text-muted">Whoops, something went wrong. It's not you, we'll work on it.</h4>
                <div class="mt-3">
                    <a href="{{route('home')}}" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
   </div>
@endsection

@extends('layouts.appError')

@section('code', $exception->getStatusCode())
@section('title', __('Service Unavailable'))

@section('image')
    <div style="background-image: url({{ asset("/svg/$exception->getStatusCode().svg") }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __($exception->getMessage() ?: 'Sorry, we are doing some maintenance. Please check back soon.'))


@extends('layouts.appMail')
@section('head')
    {{$subject}}
@endsection
@section('body')
    @include('mail.snippets.experience')
@endsection
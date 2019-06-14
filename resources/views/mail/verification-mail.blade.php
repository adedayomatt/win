
@extends('layouts.appMail')

@section('head')
    Please verify that this email belongs to you
@endsection
@section('body')
<?php //$url = url('/') ?>
    <p class="text-center">A user recently registered account on <a href="{{url('/')}}">{{config('app.name')}}</a>, we want to verify that it was you</p>
    <div class="text-center">
        <a href="{{$url}}" class="btn"> Verify Now</a>
    </div>
    <p>If it was not you, you don't need to take any action. Don't worry, this user will not be authorized to perform any action with this email </p>
    <p>If you’re having trouble clicking the "Verify Now" button, copy and paste the URL below into your browser</p>
    <p><a href="{{$url}}">{{$url}}</a></p>
    <div>
        Regards,<br>
        <strong>{{config('app.name')}}</strong>
    </div>
@endsection
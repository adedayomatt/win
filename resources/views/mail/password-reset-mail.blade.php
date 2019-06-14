
@extends('layouts.appMail')

@section('head')
    Reset your password
@endsection
@section('body')
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>We are so sorry for the loss of your password, you can reset it now</p>
    <div class="text-center">
        <a href="{{route('password.reset', $token)}}" class="btn">Reset Password Now</a>
    </div>
    <p>If you’re having trouble clicking the "Reset Password Now" button, copy and paste the URL below into your browser</p>
    <p><a href="{{route('password.reset', $token)}}">{{route('password.reset', $token)}}</a></p>
    <p>Thank you for being part the community</p>
    <div>
        Regards,<br>
        <strong>{{config('app.name')}}</strong>
    </div>
@endsection
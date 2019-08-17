
@extends('layouts.appMail')
@section('head')
    {{$subject}}
@endsection

@section('body')
    @include('mail.snippets.discussion',['discussion' => $reply->comment->discussion()])
    <div style="margin-left: 80px">
        @include('mail.snippets.user',['user' => $reply->comment->user])
        <q>{{$reply->comment->content}}</q>
        <div style="margin-left: 50px">
            @include('mail.snippets.user',['user' => $reply->user])
            <q>{{$reply->content}}</q>
        </div>
    </div>
@endsection
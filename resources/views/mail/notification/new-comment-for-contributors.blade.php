
@extends('layouts.appMail')
@section('head')
    {{$subject}}
@endsection
@section('body')
    @include('mail.snippets.discussion',['discussion' => $comment->discussion()])
    <div style="margin-left: 100px">
        @include('mail.snippets.user',['user' => $comment->user])
        <q>{{$comment->content}}</q>
    </div>
@endsection
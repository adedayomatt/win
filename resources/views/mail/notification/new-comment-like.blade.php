
@extends('layouts.appMail')

@section('head')
    {{$subject}}
@endsection

@section('body')
    @include('mail.snippets.discussion',['discussion' => $comment_like->comment->discussion()])
    <div style="margin-left: 100px">
        @include('mail.snippets.user',['user' => $comment_like->comment->user])
        <q>{{$comment_like->comment->content}}</q>
    </div>
@endsection
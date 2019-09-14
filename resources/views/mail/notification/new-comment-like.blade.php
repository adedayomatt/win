
@extends('layouts.appMail')

@section('head')
    {{$subject}}
@endsection

@section('body')
    @include('mail.snippets.discussion',['discussion' => $comment_like->comment->discussion()])
    <div style="margin-left: 20px">
        @include('mail.snippets.user',['user' => $comment_like->comment->user])
        @include('mail.snippets.comment', ['comment' => $comment_like->comment])
    </div>
@endsection
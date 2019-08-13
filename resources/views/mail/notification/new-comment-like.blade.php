
@extends('layouts.appMail')

@section('body')
    <div>
        {{$subject}}
    </div>
    @include('mail.snippets.discussion',['discussion' => $comment_like->comment->discussion()])
    <div style="margin-left: 100px">
        @include('mail.snippets.user',['user' => $comment_like->comment->user])
        <q>{{$comment->content}}</q>
    </div>
@endsection

@extends('layouts.appMail')
@section('head')
    {{$subject}}
@endsection

@section('body')
    @include('mail.snippets.discussion',['discussion' => $reply->comment->discussion()])
    <div style="margin-left: 20px">
        <div class="text-muted">Replying to {{$reply->comment->user->fullname}}</div>
        <div style="border-radius: 5px; border: 1px solid #f7f7f7; padding: 7px">
            @include('mail.snippets.user',['user' => $reply->comment->user])
            @include('mail.snippets.comment', ['comment' => $reply->comment])
        </div>
        <div style="margin-top: 8px">
            @include('mail.snippets.user',['user' => $reply->user])
            @include('mail.snippets.comment', ['comment' => $reply])
        </div>
    </div>
@endsection
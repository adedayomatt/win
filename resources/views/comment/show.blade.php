@extends('layouts.app')
@section('title')
    Comment by {{$comment->user->fullname}}
@endsection

@section('meta')
    <meta name="description" content="{{$comment->snippet}}">
    <meta name="keywords" content="insydelife, discussion, community, {{join(',',$comment->discussion()->tags->pluck('name')->toArray()) }}">
    <meta name="Author" content="{{$comment->user->fullname()}}">
    <meta property="og:title" content="{{$comment->user->fullname}} comment on {{$comment->discussion()->title}}" />
    <meta property="og:description" content="{{$comment->snippet}}" />
    <meta property="og:image" content="{{$comment->user->avatar()['src']}}" />
    <meta property="og:url" content="{{route('comment.show',[$comment->id])}}" />
    <meta property="og:type" content="article" />
@endsection



@section('styles')
    
@endsection
@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6 no-padding-xs">
            <div class="shadow-lg">
                <div style="">
                    <comment-popup :id="{{$comment->id}}"></comment-popup>
                </div>
            </div>
        </div>
    </div>
@endsection
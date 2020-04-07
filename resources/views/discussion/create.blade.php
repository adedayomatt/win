@extends('layouts.appRHSfixed')
@section('title')
    New Discussions
@endsection
@section('meta')
    <meta name="description" content="Start a new conversation">
    <meta name="keywords" content="insydelife, experience, community, tag, followers">
    <meta property="og:title" content="Start a discussion" />
    <meta property="og:description" content="Start a new conversation" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('discussion.create')}}" />
    <meta property="og:type" content="website" />
@endsection
@section('main')
        <div class="">
            <h6>Start new discussion{{isset($experience) ? ' on' : ''}}</h6>
        </div>
        <div class="content-box">
            @include('discussion.forms.create')
        </div>
@endsection
@section('RHS')
        @include('components.ads.sample')
        <div class="content-box">
            <h6>Most used tags</h6>
            <hr>
            <div style="max-height: 300px; overflow: auto">
                @include('tag.widgets.list')
            </div>
            <div class="text-right">
                <a href="{{route('tags')}}">see all tags</a>
            </div>
        </div>

@endsection
@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
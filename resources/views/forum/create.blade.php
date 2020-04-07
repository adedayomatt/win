@extends('layouts.app')
@section('title')
    New Forum
@endsection

@section('meta')
    <meta name="description" content="Create your own forum and start discussion">
    <meta name="keywords" content="insydelife, discussion, experience, community, share, learning, forum">
    <meta property="og:title" content="Create Forum" />
    <meta property="og:description" content="Create your own forum and start your discussion" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('forums')}}" />
    <meta property="og:type" content="website" />
@endsection

@section('styles')
    body{
        background-color: #F5F8FA;
    }
@endsection
@section('LHS')
        @include('components.banners.create-experience')
@endsection

@section('main')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="content-box">
            <h6>New Forum</h6>
            <hr>
            @include('forum.forms.create')
        </div>
    </div>
    <div class="col-md-4">
        <div class="content-box">
            <h6>Forums previously created</h6>
             <hr>
            <div style="max-height: 200px; overflow:auto">
                @include('forum.widgets.list', ['tags' => Auth::user()->forums])
            </div>
            <div class="text-right">
                <a href="{{route('forums')}}">All forums</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
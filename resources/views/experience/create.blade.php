@extends('layouts.appRHSfixed')
@section('title')
   New Experience
@endsection
@section('meta')
    <meta name="description" content="We'd love to read aboutyour experience on any topic, we want to learn from your success and mistakes">
    <meta name="keywords" content="insydelife, experience, community, share, learning">
    <meta property="og:title" content="Share Your Experience" />
    <meta property="og:description" content="We'd love to read aboutyour experience on any topic, we want to learn from your success and mistakes" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('experience.create')}}" />
    <meta property="og:type" content="website" />
@endsection

@section('main')
<div class="">
        <div class="">
            <h6>Share new experience</h6>
        </div>
        <div class="content-box">
            @include('experience.forms.create')
        </div>
</div>
@endsection

@section('RHS')
    @include('components.ads.sample')
    <div class="content-box" style="max=height: 200px; overflow: auto">
        <h6>Most used tags</h6>
        <hr>
        @include('tag.widgets.list')
    </div>
@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
    <!-- <script src="{{asset('js/b/image-preview.js')}}"></script> -->
@endsection
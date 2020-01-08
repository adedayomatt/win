@extends('layouts.appRHSfixed')
@section('title')
   New Experience
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
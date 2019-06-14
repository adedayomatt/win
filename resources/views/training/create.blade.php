@extends('layouts.appRHSfixed')

@section('main')
<div class="">
        <div class="text-center">
            <h6>New Training</h6>
        </div>
        <div class="content-box">
            @include('training.forms.create')
        </div>
</div>
@endsection

@section('RHS')
    @include('components.ads.sample')
    <div class="content-box" style="max=height: 200px; overflow: auto">
        <h6>Trending</h6>
        <hr>
        @include('tag.widgets.list')
    </div>
@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
    <!-- <script src="{{asset('js/b/image-preview.js')}}"></script> -->
@endsection
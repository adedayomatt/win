@extends('layouts.app')
@section('title')
    New Forum
@endsection

@section('LHS')
        @include('components.banners.create-training')
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
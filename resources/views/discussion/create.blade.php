@extends('layouts.appRHSfixed')
@section('title')
    New Discussions
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
                <a href="{{route('tags')}}">see all tagss</a>
            </div>
        </div>

@endsection
@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
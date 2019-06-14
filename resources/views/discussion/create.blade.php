@extends('layouts.appRHSfixed')


@section('main')
        <div class="text-center">
            <h6>New Discussion{{isset($training) ? ' on' : ''}}</h6>
        </div>
        <div class="content-box">
            @include('discussion.forms.create')
        </div>
@endsection
@section('RHS')
        @include('components.ads.sample')
        <div class="content-box">
            <h6>Trending</h6>
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
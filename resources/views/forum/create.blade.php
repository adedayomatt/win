@extends('layouts.appLHSfixed')

@section('LHS')
        @include('components.banners.create-post')
@endsection

@section('main')
<div class="row justify-content-center">
    <div class="col-md-8">
        @include('forum.forms.create')
    </div>
</div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
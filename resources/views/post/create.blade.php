@extends('layouts.app')

@section('LHS')
        @include('components.banners.create-post')
@endsection

@section('main')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="content-box">
            <h5>New Post</h5>
        </div>

        <div class="content-box">
            @include('post.forms.create')
        </div>
    </div>
</div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
    <script src="{{asset('js/b/image-preview.js')}}"></script>
@endsection
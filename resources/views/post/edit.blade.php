@extends('layouts.app')

@section('main')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="content-box">
            Edit Post: <strong><a href="{{route('post.show',$post->slug)}}">{{$post->title}}</a></strong>
        </div>
        <div class="content-box">
            @include('post.forms.edit')
        </div>
    </div>
</div>
@endsection

@section('RHS')

@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
    <script src="{{asset('js/b/image-preview.js')}}"></script>
@endsection
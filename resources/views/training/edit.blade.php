@extends('layouts.appRHSfixed')
@section('title')
   Trainining : {{$training->title}} | Edit
@endsection

@section('main')
<div class="justify-content-center">
        <div class="content-box">
            Edit Training: <strong><a href="{{route('training.show',$training->slug)}}">{{$training->title}}</a></strong>
        </div>
        <div class="content-box">
            @include('training.forms.edit')
        </div>
</div>
@endsection

@section('RHS')
    <p>Discussions on <strong>{{$training->title}}</strong> - {{$training->discussions->count()}}</p>
    @include('training.widgets.discussions')
@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
    {{-- <script src="{{asset('js/b/image-preview.js')}}"></script> --}}
@endsection
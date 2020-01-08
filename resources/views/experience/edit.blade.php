@extends('layouts.appRHSfixed')
@section('title')
   Experience : {{$experience->title}} | Edit
@endsection

@section('main')
    <div class="justify-content-center">
        <div class="content-box">
            Edit Experience: <strong><a href="{{route('experience.show',$experience->slug)}}">{{$experience->title}}</a></strong>
        </div>
        <div class="content-box">
            @include('experience.forms.edit')
        </div>
    </div>
@endsection

@section('RHS')
    <p>Discussions on <strong>{{$experience->title}}</strong> - {{$experience->discussions->count()}}</p>
    @include('experience.widgets.discussions')
@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
    {{-- <script src="{{asset('js/b/image-preview.js')}}"></script> --}}
@endsection
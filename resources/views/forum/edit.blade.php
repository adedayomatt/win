@extends('layouts.app')
@section('title')
    Forum :  {{$forum->name}} | Edit 
@endsection
@section('styles')
    body{
        background-color: #F5F8FA;
    }
@endsection
@section('main')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="content-box">
            <h6>Update Forum <strong><a href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a></strong></h6>
            <hr>
            @include('forum.forms.edit')
        </div>
    </div>
    <div class="col-md-4">
        <div class="content-box">
            <h6>Contributors</h6>
            <hr>
            <div style="max-height: 300px; overflow: auto">
                @include('user.widgets.list', ['users_collection' => $forum->contributors()])
            </div>
        </div>
    </div>
</div>
@endsection

@section('RHS')

@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
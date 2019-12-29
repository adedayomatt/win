@extends('layouts.app')
@section('title')
   {{$comment->user->fullname}} | Edit
@endsection

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="content-box">
                <h6>Update discussion <a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></h6>
                <hr>
                @include('discussion.forms.edit')
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-box">
                <h6>Contributors</h6>
                <hr>
                <div style="max-height: 300px; overflow: auto">
                    @include('user.widgets.list', ['users_collection' => $discussion->contributors()])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
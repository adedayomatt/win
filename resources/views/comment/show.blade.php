@extends('layouts.app')
@section('title')
    Comment by {{$comment->user->fullname}}
@endsection


@section('styles')
    
@endsection
@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6 no-padding-xs">
            <div class="shadow-lg">
                <div style="">
                    <comment-popup :id="{{$comment->id}}"></comment-popup>
                </div>
            </div>
        </div>
    </div>
@endsection
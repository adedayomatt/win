@extends('layouts.app')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg">
                <comment-popup :id="{{$comment->id}}"></comment-popup>
            </div>
        </div>
    </div>
@endsection
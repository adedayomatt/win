@extends('layouts.appRHSfixed')
@section('styles')
    .snippet{
        background-color: #fff;
    }
@endsection
@section('main')
    <h5>Discussions</h5>
    @if($discussions->count() > 0)
        @foreach($discussions as $discussion)
                 @include('discussion.widgets.snippet')
        @endforeach
    @else
    <div class="row justify-content-center">
            <div class="col-md-8 grey">
                <h5>No discussion here yet</h5>
                <a href="{{route('discussion.create')}}" class="btn btn-primary">Create one now</a>
            </div>
        </div>
    @endif
@endsection
@section('RHS')
    <div class="card">
        <div class="card-body">
        @include('tag.widgets.list')
        </div>
    </div>
@endsection


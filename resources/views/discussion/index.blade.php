@extends('layouts.appRHSfixed')

@section('main')
<div class="content-box">
    <h5>Discussions</h5>
</div>
    @if($discussions->count() > 0)
        @foreach($discussions as $discussion)
            <div class="content-box">
                 @include('discussion.widgets.snippet')
            </div>
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
    @include('tag.widget')
@endsection
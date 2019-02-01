@extends('layouts.appRHSfixed')

@section('main')
<div class="content-box">
    <h5>posts</h5>
</div>
    @if($posts->count() > 0)
        @foreach($posts as $post)
            <div class="content-box">
                 @include('post.widgets.snippet')
            </div>
        @endforeach
    @else
    <div class="row justify-content-center">
            <div class="col-md-8 grey">
                <h5>No post here yet</h5>
                <a href="{{route('post.create')}}" class="btn btn-primary">Create one now</a>
            </div>
        </div>
    @endif
@endsection
@section('RHS')
    @include('tag.widget')
@endsection
@extends('layouts.appRHSfixed')

@section('main')
    <div class="content-box">
        <div class="d-flex">
            <h5>Forum</h5>
            <a href="{{route('forum.create')}}" class="btn btn-sm btn-secondary ml-auto"><i class="fa fa-plus"></i> create new</a>
        </div>
    </div>
    @if($forums->count() > 0)
       @foreach($forums as $forum)
        <div class="content-box">
            <h5><a href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a></h5>
            <div class="text-muted">
               created by  <a href="{{route('user.profile',[$forum->user->username])}}" data-toggle="tooltip" title="{{$forum->user->fullname()}}">{{$forum->user->username()}}</a>
                {{$forum->created_at->diffForHumans()}}
            </div>
            <span class="text-muted">{{$forum->discussions->count()}} discussions</span>
            <div class="content-box">
                @include('components.owl-carousel',['carousel_collection' => $forum->discussions, 'carousel_template' => 'discussion.templates.carousel-default'])
            </div>
            
        </div>
       @endforeach
    @else
    <div class="row justify-content-center">
            <div class="col-md-8 grey">
                <h5>No forum created yet</h5>
                <a href="{{route('forum.create')}}" class="btn btn-primary">Create one now</a>
            </div>
        </div>
    @endif
@endsection
@section('RHS')
    <div class="content-box">
        @include('tag.widgets.list')
    </div>
@endsection


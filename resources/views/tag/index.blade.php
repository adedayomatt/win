@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="content-box">
        <div class="d-flex">
            <h5>Tags</h5>
            <a href="{{route('tag.create')}}" class="btn btn-sm btn-secondary ml-auto"><i class="fa fa-plus"></i> create new</a>
        </div>
    </div>
    <h6>Trending</h6>
    @include('tag.widgets.trending')
    @include('components.ads.sample')
@endsection

@section('main')
    @if($tags->count() > 0)
       @foreach($tags as $tag)
        <div class="content-bx">
            <h5><a href="{{route('tag.show',[$tag->slug])}}">#{{$tag->name}}</a></h5>
            <div class="pl-2">
                Followed by <span class="ml-2">@include('user.widgets.tiles',['users'=> $tag->users,'max' => 5])</span>
            </div>
            <div class="content-box">
                <strong class="text-muted">Discussions ({{$tag->discussions->count()}}) </strong>
                @include('components.owl-carousel',['carousel_collection' => $tag->discussions, 'carousel_template' => 'discussion.templates.carousel-default', 'carousel_layout' => ['xs'=>2,'sm'=>'2','md'=>2, 'lg'=> 3]])
                <div class="text-right"> <a href="{{route('tag.show',[$tag->slug])}}">see more discussions</a> </div>
            </div>

            <div class="content-box">
                <strong class="text-muted">Posts ({{$tag->posts->count()}}) </strong>
                @include('components.owl-carousel',['carousel_collection' => $tag->posts, 'carousel_template' => 'post.templates.carousel-default', 'carousel_layout' => ['xs'=>2,'sm'=>'2','md'=>2, 'lg'=> 3]])
                <div class="text-right"> <a href="{{route('tag.show',[$tag->slug])}}">see more posts</a> </div>
            </div>
        </div>
       @endforeach
    @else
    <div class="row justify-content-center">
            <div class="col-md-8 grey">
                <h5>No tag created yet</h5>
                <a href="{{route('tag.create')}}" class="btn btn-primary">Create one now</a>
            </div>
        </div>
    @endif
@endsection
@section('RHS')
    <h5>Forums</h5>
    @include('forum.widgets.list')
@endsection


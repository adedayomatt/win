@extends('layouts.appLHSfixedRHSfixed')

@section('LHS')
    <div class="content-box">
        <div class="d-flex">
            <h5>Tags</h5>
            <a href="{{route('tag.create')}}" class="btn btn-sm btn-theme ml-auto"><i class="fa fa-plus"></i> create new</a>
        </div>
    </div>
    <h6>Trending</h6>
    @include('tag.widgets.trending', ['carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>2]])
    @include('components.ads.sample')
@endsection

@section('main')

<tags url="/tags" id="all-tags"></tags>

    {{-- @if($tags->count() > 0)
        <div class="infinite-scroll has-tag-follow">
            @foreach($tags as $tag)
                <div class="content-box">
                    <div class="d-flex">
                        <h6><a href="{{route('tag.show',[$tag->slug])}}" class="tag">#{{$tag->name}}</a></h6>
                        <div class="ml-auto">
                            @include('tag.components.follow')
                        </div>
                    </div>
                    
                    <div class="pl-2">
                        @if($tag->users->count() > 0)
                            Followed by <span class="ml-2">@include('user.widgets.tiles',['users'=> $tag->users,'max' => 5])</span>
                        @endif 
                    </div>
                    <div class="d-flex">
                        <small class="m-1">{{$tag->discussions->count()}} discussions</small>
                        <small class="m-1">{{$tag->trainings->count()}} trainings</small>
                    </div>
                </div>
            @endforeach
            @if($tags instanceof \Illuminate\Pagination\LengthAwarePaginator )
                {{$tags->links()}}
            @endif
        </div>
       
    @else
        <div class="content-box text-muted text-center">
            <small>No tag created yet</small>
            <a href="{{route('tag.create')}}" class="btn btn-sm btn-theme">Create one now</a>
        </div>
    @endif --}}
@endsection
@section('RHS')
    <h5>Forums</h5>
    @include('forum.widgets.list')
@endsection

@section('b-scripts')
    @include('tag.components.follow-script')
@endsection


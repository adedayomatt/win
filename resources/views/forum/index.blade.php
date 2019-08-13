@extends('layouts.appLHSfixedRHSfixed')

@section('xs-styles')
.main-content{
    padding-top: 70px;
}
@endsection

@section('h-scripts')
    @include('layouts.components.typeahead.forum')
@endsection
@section('LHS')
    <div class="lhs-fixed-head bg-white">
        <div class="row py-1">
            <div class="col-8 mb-2">
                @if(isset($user))
                    @include('user.widgets.snippet')
                @endif
                <h6>Forums</h6>
            </div>
            <div class="col-4 mb-2">
                <a href="{{route('forum.create')}}" class="btn btn-sm btn-theme ml-auto"><i class="fa fa-plus"></i> create new</a>
            </div>
            <div class="col-12">
                @include('forum.widgets.search')
            </div>
        </div>
    </div>
@endsection

@section('main')
    
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-12">
            @if($forums->count() > 0)
                <div class="infinite-scroll">
                    @foreach($forums as $forum)
                            <div class="">
                                <h6><a href="{{route('forum.show',[$forum->slug])}}">{{$forum->name}}</a></h6>
                                <div class="text-muted">
                                    created by  <a href="{{route('user.profile',[$forum->user->username])}}" data-toggle="tooltip" title="{{$forum->user->fullname()}}">{{$forum->user->username()}}</a>
                                        {{$forum->created_at->diffForHumans()}}
                                    </div>
                                <span class="text-muted">{{$forum->discussions->count()}} discussions</span>
                            </div>
                                                   
                                <div class="ml-1 ml-md-4 ">
                                    @if($forum->discussions->count() > 0)
                                        <div class="content-box">
                                            @foreach($forum->discussions()->orderby('created_at', 'desc')->take(3)->get() as $discussion)
                                                <h6><a href="{{route('discussion.show',[$discussion->slug])}}">{{$discussion->title}}</a></h6>
                                                @include('discussion.widgets.meta')
                                                <hr>
                                            @endforeach
                                        </div>
                                        @if($forum->discussions->count() > 2)
                                            <div class="text-right text-muted">
                                                + <a href="{{route('forum.show',[$forum->slug])}}">{{($forum->discussions->count() -2)}} others</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="content-box">
                                            <small>No discussion in {{$forum->name}}, <a href="{{route('discussion.create')}}">create discussion</a></small>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                    @if($forums instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{$forums->links()}}
                    @endif
            </div>

            @else
            <div class="content-box text-muted text-center">
                <small>No forum created yet</small>
                <a href="{{route('forum.create')}}" class="btn btn-sm btn-theme">Create one now</a>
            </div>
            @endif
        </div>
    </div>
    
</div>
@endsection
@section('RHS')
    <div class="content-box">
        @include('tag.widgets.list')
    </div>
@endsection


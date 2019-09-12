@extends('layouts.appLHSfixedRHSfixed')

@section('xs-styles')
.main-content{
    padding-top: 70px;
}
@endsection

@section('md-styles')
.lhs-fixed{
    min-height: 300px;
}
@endsection
{{-- @section('h-scripts')
    @include('layouts.components.typeahead.discussion')
@endsection --}}
@section('LHS')
    <div class="lhs-fixed-head bg-white">
        <div class="row py-1">
            <div class="col-7 mb-2">
                @if(isset($user))
                    @include('user.widgets.snippet')
                @endif
                <h6>Discussions</h6>
            </div>
            <div class="col-5 mb-2">
                <a href="{{route('discussion.create')}}" class="btn btn-sm btn-theme ml-auto"><i class="fa fa-plus"></i> create new</a>
            </div>
            <div class="col-8">
                <div id="search-discussion">
                    <discussion-search container="#search-discussion"></discussion-search>
                </div>
            </div>
            @auth
                @if(isset($src))
                    <div class="col-4 col-md-12">
                        <div class="dropdown text-right">
                            <a id="trainingsrc" class="dropdown-toggle btn btn-default no-outline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$src == 'interests' ? 'In my interest ('.Auth::user()->interestedDiscussions()->count().')' : 'All discussions' }}
                            </a>
                            <div class="dropdown-menu text-left" aria-labelledby="trainingsrc">                            
                                <a class="dropdown-item no-whitespace" href="{{route('discussion.index',['src' => 'interests'])}}">
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            Discussions in my interests only
                                            <div class="text-muted text-center">
                                                @if(Auth::user()->tagsFollowing->count() > 0)
                                                    @foreach(Auth::user()->tagsFollowing()->take(4)->get() as $tag)
                                                        <span class="tag m-1">#{{$tag->name}}</span>
                                                    @endforeach
                                                    @if(Auth::user()->tagsFollowing->count() > 4)
                                                        <small> + {{Auth::user()->tagsFollowing->count() - 4}} others</small>
                                                    @endif
                                                @else
                                                    <small>No tag in your interest yet</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-auto color-primary">
                                            @if($src == 'interests' )
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item no-whitespace" href="{{route('discussion.index',['src' => 'all'])}}">
                                    <div class="d-flex">
                                        <div  class="mr-1">
                                            All Discussions
                                        </div>
                                        <div class="ml-auto theme-color">
                                        @if($src == 'all' )
                                                <i class="fa fa-check"></i>
                                            @endif

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
@endsection

@section('main')
    <div class="main-content">
        @if($discussions->count() > 0)
            <div class="infinite-scroll">
                @foreach($discussions as $discussion)
                        @include('discussion.widgets.snippet')
                @endforeach

                @if($discussions instanceof \Illuminate\Pagination\LengthAwarePaginator )
                    {{$discussions->appends($_GET)->links()}}
                @endif
            </div>
        @else
        <div class="content-box text-muted text-center">
            <small>No discussion yet</small>
            <a href="{{route('discussion.create')}}" class="btn btn-sm btn-theme">Create one now</a>
        </div>

        @endif
    </div>
@endsection
@section('RHS')
        @include('tag.widgets.list')
@endsection


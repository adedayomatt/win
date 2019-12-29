@extends('layouts.appLHSfixedRHSfixed')
@section('title')
  Trainings
@endsection

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
    @include('layouts.components.typeahead.training')
@endsection --}}
@section('LHS')
    <div class="lhs-fixed-head bg-white">
        <div class="row py-1">
            <div class="col-7 mb-2">
                @if(isset($user))
                    @include('user.widgets.snippet')
                @endif
                <h6>Trainings</h6>
            </div>
            <div class="col-5 mb-2">
                <a href="{{route('training.create')}}" class="btn btn-sm btn-theme ml-auto"><i class="fa fa-plus"></i> create new</a>
            </div>
            <div class="col-8">
                <div id="search-training">
                    <training-search container="#search-training"></training-search>
                </div>
            </div>
            @auth
                @if(isset($src))
                    <div class="col-4 col-md-12">
                        <div class="dropdown text-right">
                            <a id="trainingsrc" class="dropdown-toggle btn btn-default no-outline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$src == 'interests' ? 'In my interest ('.Auth::user()->interestedTrainings()->count().')' : 'All trainings' }}
                            </a>
                            <div class="dropdown-menu text-left" aria-labelledby="trainingsrc">                            
                                <a class="dropdown-item no-whitespace" href="{{route('training.index',['src' => 'interests'])}}">
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            Trainings in my interests only
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
                                        <div class="ml-auto theme-color">
                                            @if($src == 'interests' )
                                                <i class="fa fa-check"></i>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item no-whitespace" href="{{route('training.index',['src' => 'all'])}}">
                                    <div class="d-flex">
                                        <div  class="mr-1">
                                            All trainings
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
    @if($trainings->count() > 0)
        <div class="infinite-scroll">
            @foreach($trainings as $training)
                    @include('training.widgets.snippet')
            @endforeach
            @if($trainings instanceof \Illuminate\Pagination\LengthAwarePaginator )
                {{$trainings->appends($_GET)->links()}}
            @endif
        </div>
    @else
    <div class="content-box text-muted text-center">
        <small>No training published yet</small>
        <a href="{{route('training.create')}}" class="btn btn-sm btn-theme">create one now</a>
    </div>
    @endif
</div>
@endsection
@section('RHS')
        @include('tag.widgets.list')
@endsection
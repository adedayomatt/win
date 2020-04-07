@extends('layouts.appLHSfixedRHSfixed')
@section('title')
  Experiences
@endsection

@section('meta')
    <meta name="description" content="Experience they say is the best teacher, see different people's xperiences on various topics. Oppourtunity to learn from their successes and mistakes ">
    <meta name="keywords" content="insydelife, experience, community, share, learning">
    <meta property="og:title" content="See People's Experiences" />
    <meta property="og:description" content="Experience they say is the best teacher, see different people's xperiences on various topics. Oppourtunity to learn from their successes and mistakes." />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('experiences')}}" />
    <meta property="og:type" content="website" />
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
    @include('layouts.components.typeahead.experience')
@endsection --}}
@section('LHS')
    <div class="lhs-fixed-head bg-white">
        <div class="row py-1">
            <div class="col-7 mb-2">
                @if(isset($user))
                    @include('user.widgets.snippet')
                @endif
                <h6>Experiences</h6>
            </div>
            <div class="col-5 mb-2">
                <a href="{{route('experience.create')}}" class="btn btn-sm btn-theme ml-auto"><i class="fa fa-plus"></i> share new</a>
            </div>
            <div class="col-8">
                <div id="search-experience">
                    <experience-search container="#search-experience"></experience-search>
                </div>
            </div>
            @auth
                @if(isset($src))
                    <div class="col-4 col-md-12">
                        <div class="dropdown text-right">
                            <a id="experiencesrc" class="dropdown-toggle btn btn-default no-outline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$src == 'interests' ? 'In my interest ('.Auth::user()->interestedExperiences()->count().')' : 'All experiences' }}
                            </a>
                            <div class="dropdown-menu text-left" aria-labelledby="experiencesrc">                            
                                <a class="dropdown-item no-whitespace" href="{{route('experience.index',['src' => 'interests'])}}">
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            Experiences in my interests only
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
                                <a class="dropdown-item no-whitespace" href="{{route('experience.index',['src' => 'all'])}}">
                                    <div class="d-flex">
                                        <div  class="mr-1">
                                            All experiences
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
    @if($experiences->count() > 0)
        <div class="infinite-scroll">
            @foreach($experiences as $experience)
                    @include('experience.widgets.snippet')
            @endforeach
            @if($experiences instanceof \Illuminate\Pagination\LengthAwarePaginator )
                {{$experiences->appends($_GET)->links()}}
            @endif
        </div>
    @else
    <div class="content-box text-muted text-center">
        <small>No experience published yet</small>
        <a href="{{route('experience.create')}}" class="btn btn-sm btn-theme">create one now</a>
    </div>
    @endif
</div>
@endsection
@section('RHS')
        @include('tag.widgets.list')
@endsection
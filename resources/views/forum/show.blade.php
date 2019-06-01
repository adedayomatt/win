@extends('layouts.appLHSfixed')
@section('styles')
    .snippet{
        background-color: #fff;
    }
@endsection
@section('LHS')
    <div class="content-box">
        <h5>{{$forum->name}}</h5>
        <div class="text-muted">
            <p>{!!$forum->description!!}</p>
            <div class="d-flex align-items-center">
                @include('user.widgets.snippet',['user' => $forum->user])
            </div>
            <div>
                {{number_format($forum->discussions->count())}} discussions since {{$forum->created_at->diffForHumans()}}
            </div>
        </div>
    </div>
    <h6>Contributors</h6>
    @if($forum->userDiscussions()->count() > 0)
        @include('components.owl-carousel', ['carousel_collection' => $forum->userDiscussions(), 'carousel_template'=>'forum.templates.carousel-contributor', 'carousel_layout' => ['xs' => 2, 'sm' => '2', 'md' => 2, 'lg' => 2]])
    @else
        <div class="content-box text-muted text-center">
            <small>No contributors yet</small>
        </div>
    @endif
    
    <div class="jumbotron text-center">
        <h4>Place Ads Here</h4>
    </div>
@endsection

@section('main')

<h6>Discussions in {{$forum->name}}</h6>
<div class="row">
    <div class="col-md-8 no-padding-xs">
        @if($forum->discussions->count() > 0)
            @foreach($forum->discussions as $discussion)
                    @include('discussion.widgets.snippet')
            @endforeach
        @else
            <div class="content-box text-muted text-center">
                <small>No discussion in {{$forum->name}} yet</small>
                <a href="{{route('discussion.create')}}" class="btn btn-sm btn-primary">Create one now</a>
            </div>
        @endif
    </div>
    <div class="col-md-4 no-padding-xs">
    
        <h6>You may also want to see </h6>
        @include('components.owl-carousel', ['carousel_collection' => $_forums::where('id','!=',$forum->id)->take(10)->get(), 'carousel_template'=>'forum.templates.carousel-default', 'carousel_layout' => ['xs' => 2, 'sm' => '2', 'md' => 2, 'lg' => 2]])

        <div class="card mt-2">
            <div class="card-body">
                @include('tag.widgets.list')
            </div>
        </div>
        
    </div>
</div>
    
@endsection



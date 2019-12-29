@extends('layouts.appLHSfixedRHSfixed')
@section('title')
    Forum :  {{$forum->name}}
@endsection

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
    @include('components.ads.sample')
@endsection

@section('main')
<div class="text-muted text-center py-1">
    <strong>Discussions in {{$forum->name}}</strong>
</div>
    <?php $discussions = $forum->discussions()->orderby('created_at','desc')->paginate(config('custom.pagination')) ?>
    @if($discussions->count() > 0)
        <div class="infinite-scroll">
            @foreach($forum->discussions as $discussion)
                    @include('discussion.widgets.snippet')
            @endforeach
            {{$discussions->links()}}
        </div>
    @else
        <div class="text-muted text-center">
            <small>No discussion in {{$forum->name}} yet.  <a href="{{route('discussion.create')}}">create discussion</a></small>
           
        </div>
    @endif
    
        
@endsection

@section('RHS')
        @if($forum->otherForums()->count() > 0)
            <h6>You may also want to see </h6>
            @include('components.owl-carousel', ['carousel_collection' => $forum->otherForums(), 'carousel_template'=>'forum.templates.carousel-default', 'carousel_layout' => ['xs' => 2, 'sm' => '2', 'md' => 2, 'lg' => 2]])
        @endif
        <div class="">
            <div class="">
                @include('tag.widgets.list')
            </div>
        </div>
@endsection



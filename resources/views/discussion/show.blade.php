@extends('layouts.app50-50LHSfixed')
@section('title')
   {{$discussion->title}}
@endsection

@section('meta')
    <meta name="description" content="{{$discussion->snippet}}">
    <meta name="keywords" content="insydelife, discussion, community, {{join(',',$discussion->tags->pluck('name')->toArray()) }}">
    <meta name="Author" content="{{$discussion->user->fullname()}}">
    <meta property="og:title" content="Experience: {{$discussion->title}}" />
    <meta property="og:description" content="{{$discussion->snippet}}" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('discussion.show',[$discussion->slug])}}" />
    <meta property="og:type" content="article" />
@endsection

@section('styles')
    [data-role = 'unlike']{
        color: red;
    }
    .comment-area{
        position: fixed; 
        z-index: 1111;
        left: 0;
        bottom: 0;
        width: 100%;
    }
    .comment-seperator{
        height: 150px;
        }
@endsection
@section('md-styles')
    .comment-area{
        width: 50%;
        right:0;
        left: unset;
    }
@endsection
@section('after-nav')
    @include('components.modal.comment-reply')
@endsection

@section('LHS')
    <div class="card mt-2  border-0">
        <div class="card-body">
            <div class="card-title">
            @if($discussion->isMine())
                <div class="float-right">
                    @include('discussion.widgets.options')
                    <div>
                        <small data-toggle="tooltip" title="Number of users this discussion has potential of reaching according to the tags used"><i class="fa fa-users"></i> {{$discussion->reachableUsers()->count()}}</small>
                    </div>
                </div>
             @endif
            <h5>{{$discussion->title}}</h5>
            @include('discussion.widgets.meta')
            @if($discussion->fromExperience())
                <div class="ml-2">
                    @include('experience.widgets.snippet', ['experience' => $discussion->experience()])
                </div>
            @endif
            </div>
            {!! $discussion->content('full') !!}
            @include('tag.widgets.inline', ['tags' => $discussion->tags])
        </div>
    </div>
    {{-- <h6>Contributors ({{$discussion->contributions()->get()->count()}})</h6>
    <div class="">
        @if($discussion->contributions()->count() > 0)
            @include('components.owl-carousel', ['carousel_collection' => $discussion->contributions()->get(), 'carousel_template'=> 'discussion.templates.carousel-contributor', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3]])
        @else
            <div class="content-box text-muted text-center">
                No contributor yet
            </div>
        @endif
    </div> --}}
    <h6>Related Discussions</h6>
    @if($discussion->relatedDiscussions()->count() > 0)
        @include('components.owl-carousel', ['carousel_collection' => $discussion->relatedDiscussions(), 'carousel_template' => 'discussion.templates.carousel-default', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3]])
    @else
        <div class="content-box text-muted text-center">
            No related discussion
        </div>
    @endif
@endsection

@section('RHS')
    <div class=" anchor" id="comments"></div>
    <div class="row">
        <div class="col-12 col-no-padding-xs">
            <div class="widget" style="background-color: inherit">
                <div class="comments-container">
                    <discussion-comments discussion="{{$discussion->id}}" user="{{request()->get('contributor') == null ? '' : request()->get('contributor')}}"></discussion-comments>
                </div>
            </div>
        </div>
        <div class="col-12 col-no-padding-xs">
        </div>
    </div>
    <div class="comment-seperator"></div>

@endsection

@section('b-scripts')
    {{-- @include('layouts.components.ckeditor') --}}
@endsection
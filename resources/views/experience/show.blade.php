@extends('layouts.appRHSfixed')
@section('title')
  {{$experience->title}}
@endsection
@section('meta')
    <meta name="description" content="{{$experience->snippet}}">
    <meta name="keywords" content="insydelife, experience, community, {{join(',',$experience->tags->pluck('name')->toArray()) }}">
    <meta name="Author" content="{{$experience->user->fullname()}}">
    <meta property="og:title" content="{{$experience->title}}" />
    <meta property="og:description" content="{{$experience->snippet}}" />
    <meta property="og:image" content="{{$experience->cover['src']}}" />
    <meta property="og:url" content="{{route('experience.show',[$experience->slug])}}" />
    <meta property="og:type" content="article" />
@endsection

@section('styles')
    .create-discussion{
        position: fixed;
        z-index:1200;
        bottom:0;
        left: 0;
        right: 0;
        background-color: #fff;
        border-top: 1px solid #f2f2f2;
    }

@endsection
@section('main')
    <div class="card border-0">
        <div class="card-body">
            <div class="card-title">
                <div class="row">
                    <div class="col-md-8">
                        <h5>{{$experience->title}}</h5>
                    </div>
                    <div class="col-md-4">
                        @if($experience->isMine())
                            <div class="float-right">
                                @include('experience.widgets.options')
                            </div>         
                        @endif
                         @include('experience.widgets.meta')
                         <div>
                            <span data-toggle="tooltip" title="Number of users this discussion has potential of reaching according to the tags used"><i class="fa fa-users"> </i> {{$experience->reachableUsers()->count()}}</span>
                        </div>
                    </div>
                </div>
                
               
            </div>
            @if($experience->media->count() > 0)
                <div class="row justify-content-center">
                    @foreach($experience->media as $media)
                        <div class="col-sm-6 col-md-4 p-0">
                            <div class="p-1">
                                @if($media->isPhoto())
                                    @include('experience.media.photo',['media' => $media])
                                @elseif($media->isVideo())
                                    @include('experience.media.video',['media' => $media])
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="content-container">
                {!! $experience->content('full') !!}
            </div>
        </div>
            @include('tag.widgets.inline', ['tags' => $experience->tags])

    </div>

    <div id="discussions" class="anchor"></div>
    
    <div class="">
        <div class="py-4">
            <div class="text-muted text-center">
                <strong>Discussions on {{$experience->title}} ({{$experience->discussions->count()}})</strong>
            </div>
            @include('experience.widgets.discussions')
        </div>
    </div>

    <div class="text-center p-2 create-discussion">
        Discuss this in a forum, <a href="{{route('experience.discuss',[$experience->slug])}}">start a discusion</a>
    </div>

@endsection

@section('RHS')
<div class="pb-5">
    <h6>Related experiences</h6>
    @include('experience.widgets.list',['experience_w_collection' => $experience->relatedExperiences()])
</div>
@endsection

@section('b-scripts')
    <script>
            $('.content-container img').css({'width':'auto','max-width': '100%'})
    </script>
@endsection
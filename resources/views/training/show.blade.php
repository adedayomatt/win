@extends('layouts.appRHSfixed')
@section('title')
  {{$training->title}}
@endsection

@section('styles')
    .create-discussion{
        position: fixed;
        z-index:1200;
        bottom:0;
        left: 0;
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
                        <h5>{{$training->title}}</h5>
                    </div>
                    <div class="col-md-4">
                        @if($training->isMine())
                            <div class="float-right">
                                @include('training.widgets.options')
                            </div>         
                        @endif
                         @include('training.widgets.meta')
                         <div>
                            <span data-toggle="tooltip" title="Number of users this discussion has potential of reaching according to the tags used"><i class="fa fa-users"> </i> {{$training->reachableUsers()->count()}}</span>
                        </div>
                    </div>
                </div>
                
               
            </div>
            @if($training->media->count() > 0)
                <div class="row justify-content-center">
                    @foreach($training->media as $media)
                        <div class="col-sm-6 col-md-4 p-0">
                            <div class="p-1">
                                @if($media->isPhoto())
                                    @include('training.media.photo',['media' => $media])
                                @elseif($media->isVideo())
                                    @include('training.media.video',['media' => $media])
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="content-container">
                {!! $training->content('full') !!}
            </div>
        </div>
            @include('tag.widgets.inline', ['tags' => $training->tags])

    </div>

    <div id="discussions" class="anchor"></div>
    
    <div class="">
        <div class="py-4">
            <div class="text-muted text-center">
                <strong>Discussions on {{$training->title}} ({{$training->discussions->count()}})</strong>
            </div>
            @include('training.widgets.discussions')
        </div>
    </div>

    <div class="text-right p-2 create-discussion">
        Discuss "{{str_limit($training->title,100)}}" in a forum, <a href="{{route('training.discuss',[$training->slug])}}">start a discusion</a>
    </div>

@endsection

@section('RHS')
    <h6>Related trainings</h6>
    @include('training.widgets.list',['training_w_collection' => $training->relatedTrainings()])
@endsection

@section('b-scripts')
    <script>
            $('.content-container img').css({'width':'auto','max-width': '100%'})
    </script>
@endsection
@extends('layouts.app50-50RHSfixed')

@section('after-nav')
    @include('components.modal.comment-reply')
@endsection

@section('LHS')
    <div class="card border-0 mt-2">
        <div class="card-body ">
            <div class="card-title">
                <h5>{{$discussion->title}}</h5>
                @include('discussion.widgets.meta')
                @if($discussion->fromPost())
                    <?php $post = $discussion->post ?>
                    <div class="ml-5">
                        @include('post.widgets.snippet')
                    </div>
                @endif
            </div>
            {!! $discussion->content('full') !!}
        </div>
    </div>

    <?php $tags = $discussion->tags ?>
        @include('tag.widget-alt')

            <div class="content-box">
                @auth()
                    <?php $user = Auth::user()?>
                    @include('user.widgets.snippet')
                    @include('comment.create')
                @endauth
                @guest()
                    <p><a href="{{route('login')}}" class="btn btn-primary">Sign in</a> or <a href="{{route('register')}}" class="btn btn-success">Sign up</a> to contribute to the discussion</p>
                @endguest
            </div>
@endsection

@section('RHS')
    <div class=" anchor" id="comments"></div>
    <div class="row">
        <div class="col-md-6 col-no-padding-xs">
            <div class="card widget">
                <div class="card-header">
                    <h5>Comments ( <span class="figure">{{$discussion->comments->count()}}</span> )</h5>
                </div>
                <div class="card-body">
                    @if($discussion->comments->count() > 0)
                        @include('comment.comments')
                    @else
                        <div class="text-center p-2">
                            <small class="text-danger">No comment yet</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-no-padding-xs">
            <?php
                $w_title = "Related discussions";
                $w_collection = $discussion->relatedDiscussions();
            ?>
            @include('discussion.widgets.list')
        </div>
    </div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
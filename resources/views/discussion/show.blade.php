@extends('layouts.app50-50RHSfixed')

@section('after-nav')
    @include('components.modal.comment-reply')
@endsection

@section('LHS')
    <div class="card mt-2">
        <div class="card-body ">
            <div class="card-title">
                <h5>{{$discussion->title}}</h5>
                @include('discussion.widgets.meta')
                @if($discussion->fromPost())
                    <div class="ml-5">
                        @include('post.widgets.snippet', ['post' => $discussion->post])
                    </div>
                @endif
            </div>
            {!! $discussion->content('full') !!}
            @include('tag.widgets.inline', ['tags' => $discussion->tags])
        </div>
    </div>
        <strong>Contributors ({{$discussion->contributions()->get()->count()}})</strong>
        <div class="">
            @if($discussion->contributions()->count() > 0)
                @include('components.owl-carousel', ['carousel_collection' => $discussion->contributions()->get(), 'carousel_template'=> 'discussion.templates.carousel-contributor', 'carousel_layout' => ['xs'=>2,'sm'=>2,'md'=>2,'lg'=>3]])
            @else
                <p class="text-muted text-center">No contributor yet</p>
            @endif
        </div>
        <div class="content-box">
            @auth()
                @include('user.widgets.snippet',['user' =>  Auth::user()])
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
                    <h6>Comments (<span class="figure">{{$discussion->comments->count()}}</span>)</h6>
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
            <h6>Related Discussions</h6>
            <?php
                $w_collection = $discussion->relatedDiscussions();
            ?>
            @include('discussion.widgets.list')
        </div>
    </div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
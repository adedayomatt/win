@extends('layouts.appRHSfixed')

@section('main')
    <div class="card border-0">
        <div class="card-body">
            <div class="card-title">
                <h5>{{$post->title}}</h5>
                @include('post.widgets.meta')
            </div>
            {!! $post->content('full') !!}
        </div>
            @include('tag.widgets.inline', ['tags' => $post->tags])

    </div>

    <div class="text-right">
        <a href="{{route('post.discuss',[$post->slug])}}" class="btn btn-secondary">Start a discusion</a>
    </div>

    <div id="discussions" class="anchor"></div>
    
    <div class="content-box">
        <div class="py-4">
            <p>Discussions on <strong>{{$post->title}}</strong> - <span class="badge badge-secondary figure">{{$post->discussions->count()}}</span></p>
            @include('post.widgets.discussions')
        </div>


    </div>

@endsection

@section('RHS')
    <?php
    
    $w_title = "Related posts";
    $w_collection = $post->relatedPosts();
?>
    @include('post.widgets.list')
@endsection
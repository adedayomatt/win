@extends('layouts.appLHSfixedRHSfixed')
@section('title')
    #{{$tag->name}}
@endsection
@section('meta')
    <meta name="description" content="See experiences and discussions tagged #{{$tag->name}}">
    <meta name="keywords" content="insydelife, experience, community, tag">
    <meta property="og:title" content="#{{$tag->name}} on insydelife" />
    <meta property="og:description" content="See experiences and discussions tagged #{{$tag->name}} {{$tag->description !== null ? ' - '.$tag->description : ''}}" />
    <meta property="og:image" content="{{asset('asset/insydelife-logo-425x125.png')}}" />
    <meta property="og:url" content="{{route('tag.show',[$tag->slug])}}" />
    <meta property="og:type" content="website" />
@endsection

@section('styles')
    .after-fixed-head{
        padding-top: 82px;
    }
@endsection
@section('LHS')
    <div class="lhs-fixed-head has-tag-follow bg-white p-2">
        <div class="d-flex">
            <h6><a href="{{route('tag.show',[$tag->slug])}}" class="tag">#{{$tag->name}}</a></h6>
            <div class="ml-auto">
                @include('tag.components.follow')
            </div>
        </div>
        <div class="text-muted">
            @include('tag.widgets.meta',['tag' => $tag])
        </div>
    </div>
    <div class="after-fixed-head">
        @if($tag->description != null)
            <strong class="text-muted">Description</strong>
            <div class="content-box text-muted">
                {!!$tag->description!!}
            </div>
        @endif
        <h6>Other tags </h6>
        @include('components.owl-carousel', ['carousel_collection' => $tag->otherTags($raw = true)->take(10)->get(), 'carousel_template'=> 'tag.templates.carousel-default','carousel_layout' => ['xs' => 2, 'sm' => '2', 'md' => 2, 'lg' => 2]])
        @include('components.ads.sample')
    </div>
@endsection


@section('main')
            <div class="text-muted text-center py-1">
                <strong>Feeds in <span class="tag">#{{$tag->name}}</span></strong>
            </div>
            <feeds url="{{"/tag/$tag->id/feeds"}}"></feeds>
@endsection

@section('RHS')
    <div class="card">
        <div class="card-body">
            <h6>Followed by:</h6>
            <hr>
            <div style="max-height: 300px; overflow: auto">
                @include('user.widgets.list', ['users_collection' => $tag->users()->take(10)->get()])
                @if($tag->users()->count() > 10)
                    <div class="text-muted text-right">
                        + {{$tag->users()->count() - 10 }} others, <a href="#">see all followers</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <h6>Most used tags</h6>
    @include('tag.widgets.trending', ['carousel_layout' => ['xs' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2] ])
@endsection





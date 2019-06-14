@extends('layouts.appLHSfixedRHSfixed')
@section('styles')
    .after-fixed-head{
        padding-top: 72px;
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
            @include('tag.widgets.meta',['tag' => $tag, 'active'=>'followers'])
        </div>
    </div>

    <div class="after-fixed-head">
        @if($tag->description != null)
            <strong class="text-muted">Description</strong>
            <div class="content-box text-muted">
                {!!$tag->description!!}
            </div>
        @endif

    </div>

@endsection


@section('main')
        <div class="py-1 text-center">
            <strong class="text-muted"><span class="tag">#{{$tag->name}}</span> followers</strong> 
        </div>
        @if($followers->count() > 0)
            <div class="infinite-scroll">
                @foreach($followers as $follower)
                    <div class="content-box">
                        @include('user.widgets.snippet', ['user' => $follower])
                    </div>
                @endforeach
                {{$followers->links()}}
            </div>
        @else
            <div class="text-center text-muted">
                    No follower yet
            </div>
        @endif    
                
@endsection

@section('RHS')
    <div class="card">
        <div class="card-body">
            <h6>Other tags</h6>
            <hr>
            <div style="max-height: 300px; overflow: auto">
                @include('tag.widgets.list', ['tags' => $tag->otherTags()])
            </div>
        </div>
    </div>
    <h6>Trending</h6>
    @include('tag.widgets.trending', ['carousel_layout' => ['xs' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2] ])
@endsection

@section('b-scripts')
    @include('tag.components.follow-script')
@endsection




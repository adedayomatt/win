@extends('layouts.appLHSfixedRHSfixed')
@section('title')
    #{{$tag->name}} : Experiences
@endsection

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
            @include('tag.widgets.meta',['tag' => $tag, 'active'=>'experiences'])
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
            <strong class="text-muted">Posts in <span class="tag">#{{$tag->name}}</span></strong> 
        </div>
        @if($experiences->count() > 0)
            <div class="infinite-scroll">
                @foreach($experiences as $experience)
                        @include('experience.widgets.snippet', ['experience' => $experience])
                @endforeach
                {{$experiences->links()}}
            </div>
        @else
            <div class="text-center text-muted">
                    No experience in {{$tag->name}} yet.
                    <a href="{{route('experience.create')}}" class="btn btn-sm btn-theme">share experience</a>
            </div>
        @endif    
                
@endsection

@section('RHS')
    <div class="card">
        <div class="card-body">
            <h6>Followed by:</h6>
            <hr>
            <div style="max-height: 300px; overflow: auto">
                @include('user.widgets.list', ['users_collection' => $tag->users])
            </div>
        </div>
    </div>
    <h6>Most used tags</h6>
    @include('tag.widgets.trending', ['carousel_layout' => ['xs' => 2, 'sm' => 2, 'md' => 2, 'lg' => 2] ])
@endsection

@section('b-scripts')
    @include('tag.components.follow-script')
@endsection




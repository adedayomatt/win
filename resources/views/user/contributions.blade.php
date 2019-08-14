@extends('layouts.appLHSfixedRHSfixed')

@section('xs-styles')
.main-content{
    padding-top: 70px;
}
@endsection

@section('md-styles')
.lhs-fixed{
    min-height: 300px;
}
@endsection

@section('LHS')
    <div class="lhs-fixed-head bg-white">
        <div class="row py-1">
            <div class="col-8 mb-2">
                @include('user.widgets.snippet')
                <div class="text-muted">
                    <h6>Contributions</h6>
                    {{number_format($user->discussionContributions()->sum('total_comments'))}} comments in {{number_format($user->discussionContributions()->count())}} discussions
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <div class="main-content">
        @if($contributions->count() > 0)
            <div class="content-bo">
                <div class="infinite-scroll">
                    @foreach($contributions as $contribution)
                        <div class="content-box">
                            @include('discussion.templates.list', ['discussion' => $contribution->discussion()])
                            @if(!$contribution->discussion()->isTrashed())
                                <div class="text-right text-muted">
                                    <p>contributed <a href="{{route('discussion.show', [$contribution->discussion()->slug])}}?contributor={{$user->username}}">{{$contribution->total_comments}} comments</a></p>
                                </div>
                            @endif
                        </div>
                    @endforeach 
                    @if($contributions instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{$contributions->links()}}
                    @endif
                 </div>
            </div>
            @else
                @if($user->auth())
                    <div class="content-box">
                    <p class="text-center text-muted">You have not made any contributions yet. Here are some suggestions</p> 

                    @if($user->interestedDiscussions()->count() > 0)
                        @include('discussion.widgets.list', ['w_collection' => $user->interestedDiscussions()])
                    @else
                        <div class="text-muted text-center">
                            <h1 class="fa fa-exclamation-triangle"></h1>
                            <p>No suggestion</p>
                        </div>
                    @endif
                    </div>
                @else
                    <div class="text-muted content-box">
                        No contribution by {{$user->firstname}}
                    </div>
                @endif
            @endif

    </div>
@endsection
@section('RHS')
    <div class="card">
        <div class="card-body">
        @include('tag.widgets.list')
        </div>
    </div>
@endsection


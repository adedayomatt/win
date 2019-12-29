@extends('layouts.appLHSfixed')
@section('title')
  Users
@endsection

@section('xs-styles')
.after-fixed-head{
    padding-top: 60px;
}
@endsection

@section('LHS')
    <div class="lhs-fixed-head bg-white p-2">
        <strong class="text-muted d-block">Users</strong>
        <div id="user-search">
            <user-search container="#user-search"></user-search>
        </div>
        
    </div>
@endsection

@section('main')
<div class="after-fixed-head">
    <div class="row py-1">
        <div class="col-sm-8 col-md-6">
            @if($users->count() > 0)
                <div class="infinite-scroll">
                    @foreach($users as $user)
                        <div class="content-box">
                            @include('user.widgets.snippet')
                        </div>
                    @endforeach
                    {{$users->links()}}
                </div>
            @else
                <div class="text-muted text-center py-2">
                    No user found
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
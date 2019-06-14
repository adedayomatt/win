@extends('layouts.app')

@section('main')
<div class="mt-50">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-8">
            <form action="{{route('add.interests',[$user->username])}}" method="POST">
                @csrf    
                <div class="content-box mt-5">
                    <div style="padding: 40px 0">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @include('user.widgets.snippet')
                                <div class="text-center">
                                    @if(isNewUser())
                                        <p class="text-muted">We are so glad to have you join this community, <strong>{{$user->firstname}}</strong></p>
                                        <h5>Just one more thing</h5>
                                    @endif
                                    <p>Select tags to follow. We'll use this to customize what you see on your feeds</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('tag.components.select')
                                @include('tag.widgets.suggestions',['suggestions' => $_tags::whereNotIn('id', $user->interests())->get()])
                                <input type="submit" class="btn btn-block btn-primary" value="Add interests">
                            </div>
                        </div>
                        </div>
                        <hr>
                        <p class="text-center">But it's okay if you want to skip this</p>
                        <div class="text-right">
                            <a href="{{route('home')}}" class="btn btn-sm btn-theme">skip</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

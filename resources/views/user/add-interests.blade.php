@extends('layouts.app')

@section('main')
<div class="mt-50">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-6">
            <div class="content-box mt-5">
                <div style="padding: 40px 0">
                    @include('user.widgets.snippet')
                    <div class="text-center">
                        <h4>Just one more thing</h4>
                        <p>Select tags to follow. We'll use this to customize what you see on your feeds</p>
                    </div>
                   
                    <form action="{{route('add.interests',[$user->username])}}" method="POST">
                        @csrf
                        @include('tag.components.attach')
                        <input type="submit" class="btn btn-block btn-primary" value="Add interests">
                    </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

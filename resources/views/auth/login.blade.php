@extends('layouts.plain')

@section('main')
<div class="mt-50">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-6">
            <div class="content-box">
                <div style="padding: 40px 0">
                    <div class="text-center">
                        <h4>Sign in</h4>
                        <p>Don't have an account yet? <a href="{{route('register')}}">Sign up now</a></p>
                    </div>
                    <div class="mt-10">
                        @include('user.forms.login')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

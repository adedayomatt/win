@extends('layouts.plain')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
            <div class="content-box">
                <div class="text-center">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('user.verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
@endsection

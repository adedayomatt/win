
@extends('layouts.appMail')

@section('body')
    <div>
        {{$subject}}
    </div>
    @include('mail.snippets.discussion')
@endsection
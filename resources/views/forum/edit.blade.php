@extends('layouts.appRHSfixed')

@section('main')
<div class="row justify-content-center">
    <div class="col-md-8">
        @include('forum.forms.edit')
    </div>
</div>
@endsection

@section('RHS')

@endsection


@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
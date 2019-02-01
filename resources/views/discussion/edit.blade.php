@extends('layouts.app')

@section('main')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('discussion.forms.edit')
        </div>
    </div>
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
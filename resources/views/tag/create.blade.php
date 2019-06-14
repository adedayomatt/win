@extends('layouts.app')

@section('main')
    <div class="row justify-content-center ">
        <div class="col-md-4">
            <div class="content-box">
            {!!Form::open(['route' => 'tag.store', 'method' => 'POST'])!!}
                <h6>New tag</h6>
                <hr>
                <div class="form-group">
                    {{form::label('name', 'Tag Name')}}
                    {{form::text('name',old('name'),['class'=>'form-control', 'placeholder'=>'tag name','required','autofocus'])}}
                    @if($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>  

                <div class="form-group">
                    {{form::label('description', 'Description')}}
                    {{form::textarea('description',old('description'),['id'=>'','class'=>'form-control textarea','placeholder'=>'about this tag...'])}}
                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 offset-sm-3">
                        {{Form::submit('Create',['class' => 'btn btn-theme btn-block'])}}
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-box">
                <h6>Prev. tags</h6>
                <hr>
                <span class="text-muted">By you:</span>
                <hr>
                <div style="max-height: 200px; overflow:auto">
                    @include('tag.widgets.list', ['tags' => Auth::user()->tags])
                </div>
                <span class="text-muted">All</span>
                <hr>
                <div style="max-height: 300px; overflow:auto">
                    @include('tag.widgets.list')
                </div>
                <div class="text-right">
                    <a href="{{route('tags')}}">All tags</a>
                </div>
            </div>
        </div>
    </div>
@endsection

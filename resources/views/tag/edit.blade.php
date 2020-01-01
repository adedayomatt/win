@extends('layouts.app')
@section('title')
    #{{$tag->name}} | Edit
@endsection
@section('styles')
    body{
        background-color: #F5F8FA;
    }
@endsection
@section('main')
    <div class="row justify-content-center ">
        <div class="col-sm-5 col-md-4">
            <div class="content-box">
                <h6>Update Tag <a class="tag" href="{{route('tag.show',$tag->slug)}}">#{{$tag->name}}</a></h6>
                <hr>
                    {!!Form::open(['route' => ['tag.update',$tag->slug], 'method' => 'POST'])!!}
                    @method('PUT')
                    <!-- <div class="form-group">
                        {{form::label('name', 'Tag Name')}}
                        {{form::text('name',$tag->name,['class'=>'form-control', 'placeholder'=>'tag name','required','autofocus'])}}
                        @if($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>   -->

                    <div class="form-group">
                        {{form::label('description', 'Description')}}
                        {{form::textarea('description',$tag->description,['class'=>'form-control textarea','placeholder'=>'about this tag...'])}}
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 offset-sm-3">
                            {{Form::submit('Update',['class' => 'btn btn-success btn-block'])}}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-sm-5 col-md-4">
            <div class="content-box">
                <h6>Followed by:</h6>
                <hr>
                <div style="max-height: 300px; overflow: auto">
                    @include('user.widgets.list', ['users_collection' => $tag->followers()])
                </div>
            </div>
        </div>
    </div>
@endsection

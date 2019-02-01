@extends('layouts.appRHSfixed')

@section('main')
    <div class="row justify-content-center ">
        <div class="col-md-8 shadow-lg">
            {!!Form::open(['route' => ['tag.update',$tag->slug], 'method' => 'POST'])!!}
                @method('PUT')
                <h4>Update Tag <a class="tag" href="{{route('tag.show',$tag->slug)}}">{{$tag->name}}</a></h4>
                <div class="form-group">
                    {{form::label('name', 'Tag Name')}}
                    {{form::text('name',$tag->name,['class'=>'form-control', 'placeholder'=>'tag name','required','autofocus'])}}
                    @if($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>  

                <div class="form-group">
                    {{form::label('description', 'Description')}}
                    {{form::textarea('description',$tag->description,['id'=>'ckeditor','class'=>'form-control','placeholder'=>'about this tag...'])}}
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
@endsection

@section('RHS')
    <?php
        $w_title = "Posts";
        $w_collection = $tag->posts;
    ?>
    @include('post.widgets.list')
@endsection

@section('b-scripts')
    @include('layouts.components.ckeditor')
@endsection
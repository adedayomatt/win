{!!Form::open(['route' => ['forum.update',$forum->id], 'method' => 'PUT'])!!}
    <fieldset>
        <div class="form-group">
            {{form::label('forum_name', 'Forum name')}}
            {{form::text('forum_name',$forum->name,['class'=>'form-control', 'placeholder'=>'forum name...','required', 'autofocus'])}}
            @if ($errors->has('forum_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('forum_name') }}</strong>
                </span>
            @endif
        </div>  


        <div class="form-group">
            {{form::label('description', 'Description')}}
            {{form::textarea('description',$forum->description,['class'=>'form-control textarea', 'placeholder'=>'description of this forum...', 'autofocus'])}}
            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </fieldset>
    
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {{Form::submit('Update',['class' => 'btn btn-success btn-block btn-theme'])}}
        </div>
    </div>
{!! Form::close() !!}

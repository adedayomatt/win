{!!Form::open(['route' => 'forum.store', 'method' => 'POST'])!!}
    <fieldset>
        <legend>New Forum</legend>

        <div class="form-group">
            {{form::label('forum_name', 'Forum name')}}
            {{form::text('forum_name',old('forum_name'),['class'=>'form-control', 'placeholder'=>'forum name...','required', 'autofocus'])}}
            @if ($errors->has('forum_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('forum_name') }}</strong>
                </span>
            @endif
        </div>  


        <div class="form-group">
            {{form::label('description', 'Description')}}
            {{form::textarea('description',old('description'),['id'=>'ckeditor','class'=>'form-control', 'placeholder'=>'description of this forum...', 'required', 'autofocus'])}}
            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </fieldset>
    
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {{Form::submit('Create',['class' => 'btn btn-success btn-block'])}}
        </div>
    </div>
{!! Form::close() !!}

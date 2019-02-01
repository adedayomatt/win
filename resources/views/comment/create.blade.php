{!!Form::open(['route' => ['comment.store',$discussion->slug], 'method' => 'POST'])!!}
    <div class="form-group">
            {{form::label('comment', 'Your comment')}}
            {{form::textarea('comment',old('comment'),['class'=>'ckeditor form-control', 'placeholder'=>'your comment on "$dicussion->title"', 'required'])}}
            @if ($errors->has('comment'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('comment') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group row">
            <div class="col-sm-4">
                {{Form::submit('Add comment',['class' => 'btn btn-success btn-block'])}}
            </div>
        </div>

{!! Form::close() !!}


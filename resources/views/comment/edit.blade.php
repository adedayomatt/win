{!!Form::open(['route' => ['comment.update',$discussion->slug,$comment->id], 'method' => 'POST'])!!}
    <div class="form-group">
            {{form::label('comment', 'Your comment')}}
            {{form::textarea('comment',$comment->content,['id'=>'ckeditor','class'=>'form-control', 'placeholder'=>'your comment on "$dicussion->title"', 'required', 'autofocus'])}}
            @if ($errors->has('comment'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('comment') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group row">
            <div class="col-sm-6 offset-sm-3">
                {{Form::submit('Update',['class' => 'btn btn-success btn-block'])}}
            </div>
        </div>
{!! Form::close() !!}


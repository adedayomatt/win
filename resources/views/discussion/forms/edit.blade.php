{!!Form::open(['route' => ['discussion.update',$discussion->id], 'method' => 'POST'])!!}
    @method('PUT')
    <fieldset>
        <legend>Update Discussion</legend>
        <div class="form-group">
            {{form::label('discussion_title', 'Title')}}
            {{form::text('discussion_title',$discussion->title,['class'=>'form-control', 'placeholder'=>'Title of your discussion','required', 'autofocus'])}}
            @if ($errors->has('discussion_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('discussion_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group row">
            <div class="col-sm-4">
                {{form::label('forum', 'Forum')}}
            </div>
            <div class="col-sm-8">
                <?php
                    $forums = array();
                    foreach($_forums::all() as $f){
                        $forums["$f->id"] = $f->name; 
                    }
                ?>
                {{form::select('forum',$forums,$discussion->forum_id,
                ['class'=>'form-control','placeholder' => 'Select category','required'])}}
                @if ($errors->has('category'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('forum') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group">
            {{form::label('content', 'Content')}}
            {{form::textarea('content',$discussion->content,['id'=>'ckeditor','class'=>'form-control', 'placeholder'=>'content of your discussion...', 'required', 'autofocus'])}}
            @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group row justify-content-center">
            <div class="col-sm-8">
            <?php $prevTags = $discussion->tags ?>
                @include('tag.components.attach')
            </div>
        </div>


    </fieldset>       
    
    <div class=" form-group row">
        <div class="col-sm-6 offset-sm-3">
            {{Form::submit('Update',['class' => 'btn btn-success btn-block'])}}
        </div>
    </div>
{!! Form::close() !!}

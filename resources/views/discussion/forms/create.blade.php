{!!Form::open(['route' => 'discussion.store', 'method' => 'POST'])!!}
    @if(isset($training))
        @include('training.widgets.snippet')
        {{form::hidden('training',$training->id)}}
    @endif
    <fieldset>
        <div class="form-group">
            {{form::label('discussion_title', 'Title')}}
            {{form::text('discussion_title', old('discussion_title') ? old('discussion_title') : (isset($title) ? $title : ''),['class'=>'form-control', 'placeholder'=>'Title of your discussion','required', 'autofocus'])}}
            @if ($errors->has('discussion_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('discussion_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group">
            {{form::label('content', 'Content')}}
            {{form::textarea('content',old('content'),['class'=>'ckeditor form-control', 'placeholder'=>'content of your discussion...', 'required', 'autofocus'])}}
            @if ($errors->has('content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{form::label('forum', 'Forum')}}
                    <?php
                        $forums = array();
                        foreach($_forums::all() as $f){
                            $forums["$f->id"] = $f->name; 
                        }
                    ?>
                    {{form::select('forum',$forums,null,
                    ['class'=>'form-control','placeholder' => 'Select forum','required'])}}
                    @if ($errors->has('forum'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('forum') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group justify-content-center">
                    <label for="">Select tags</label>
                    <tag-select :selected="[]"></tag-select>
                </div>
            </div>
        </div>
        {{Form::submit('Create',['class' => 'btn btn-theme'])}}
</fieldset>
{!! Form::close() !!}

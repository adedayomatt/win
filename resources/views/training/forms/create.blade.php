{!!Form::open(['route' => 'training.store', 'method' => 'POST' ,'files' => true])!!}
    <fieldset>
        <div class="form-group">
            {{form::label('training_title', 'Title')}}
            {{form::text('training_title',old('training_title'),['class'=>'form-control', 'placeholder'=>'Title of your training','required', 'autofocus'])}}
            @if ($errors->has('training_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('training_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group">
            {{form::label('training_content', 'Training content')}}
            {{form::textarea('training_content',old('training_content'),['class'=>'ckeditor form-control', 'placeholder'=>'content of your training...', 'required', 'autofocus'])}}
            @if ($errors->has('training_content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('training_content') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group justify-content-center">
                    <label for="">Select tags</label>
                    <tag-select :selected="[]"></tag-select>
                </div>
            </div>
        </div>
       

    <div class="row">
        <div class="col-12 col-sm-8 col-md-6">
            <div class="text-center">
                <img class="image-responsive" id="cover" src="" alt="" width="100%">
                <div class="image-preview-container" replace="#cover"></div>
            </div>
        </div>
        <div class="col-md-8">
            <label class="">Add photo/video to training</label>
            <div class="form-group">
                {{form::file('media[]',['class' => 'form-control','accept' =>'image/*,video/*', 'multiple'])}}
                @if ($errors->has('cover'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cover') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
        {{Form::submit('Publish training',['class' => 'btn btn-theme'])}}
    </fieldset>

{!! Form::close() !!}

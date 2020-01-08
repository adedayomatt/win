{!!Form::open(['route' => 'experience.store', 'method' => 'POST' ,'files' => true])!!}
    <fieldset>
        <div class="form-group">
            {{form::label('experience_title', 'Title')}}
            {{form::text('experience_title',old('experience_title'),['class'=>'form-control', 'placeholder'=>'Title of your experience','required', 'autofocus'])}}
            @if ($errors->has('experience_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('experience_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group">
            {{form::label('experience_content', 'Experience content')}}
            {{form::textarea('experience_content',old('experience_content'),['class'=>'ckeditor form-control', 'placeholder'=>'content of your experience...', 'required', 'autofocus'])}}
            @if ($errors->has('experience_content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('experience_content') }}</strong>
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
            <label class="">Add photo/video to experience</label>
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
        {{Form::submit('Publish experience',['class' => 'btn btn-theme'])}}
    </fieldset>

{!! Form::close() !!}

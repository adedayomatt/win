{!!Form::open(['route' => 'post.store', 'method' => 'POST','class' =>'has-image-upload' ,'files' => true])!!}
    <fieldset>
        <legend>New Post</legend>

        <div class="form-group">
            {{form::label('post_title', 'Title')}}
            {{form::text('post_title',old('post_title'),['class'=>'form-control', 'placeholder'=>'Title of your post','required', 'autofocus'])}}
            @if ($errors->has('post_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('post_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group row">
            <div class="col-sm-4">
                {{form::label('category', 'Category')}}
            </div>
            <div class="col-sm-8">
                <?php
                    $categories = array();
                    foreach($_postCategories::all() as $c){
                        $categories["$c->id"] = $c->name; 
                    }
                ?>
                {{form::select('category',$categories,null,
                ['class'=>'form-control','placeholder' => 'Select category','required'])}}
                @if ($errors->has('category'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('category') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group">
            {{form::label('body', 'Body')}}
            {{form::textarea('body',old('body'),['id'=>'ckeditor','class'=>'form-control', 'placeholder'=>'content of your post...', 'required', 'autofocus'])}}
            @if ($errors->has('body'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>
    </fieldset>

    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6">
            <div class="text-center">
                <img class="image-responsive" id="cover" src="" alt="" width="100%">
                <div class="image-preview-container" replace="#cover"></div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="form-group">
                {{form::file('cover',['class' => 'form-control','accept' =>'image/*'])}}
                @if ($errors->has('cover'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cover') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {{Form::submit('Create',['class' => 'btn btn-success btn-block'])}}
        </div>
    </div>
{!! Form::close() !!}

{!!Form::open(['route' => ['post.update',$post->id], 'method' => 'POST','class' =>'has-image-upload' ,'files' => true])!!}
    @method('PUT')
    <fieldset>
        <div class="form-group">
            {{form::label('post_title', 'Title')}}
            {{form::text('post_title',$post->title,['class'=>'form-control', 'placeholder'=>'Title of your post','required', 'autofocus'])}}
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
                {{form::select('category',$categories,$post->category->id,
                ['class'=>'form-control','placeholder' => 'Select category','required'])}}
                @if ($errors->has('category'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('category') }}</strong>
                    </span>
                @endif
            </div>
        </div>


        <div class="form-group">
            {{form::label('post_content', 'Post content')}}
            {{form::textarea('post_content',$post->content,['class'=>'ckeditor form-control', 'placeholder'=>'content of your post...', 'required', 'autofocus'])}}
            @if ($errors->has('post_content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('post_content') }}</strong>
                </span>
            @endif
        </div>
    </fieldset>

    <div class="form-group row justify-content-center">
            <div class="col-sm-8">
            <?php $prevTags = $post->tags ?>
                @include('tag.components.attach')
            </div>
        </div>

    
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {{Form::submit('Update',['class' => 'btn btn-success btn-block'])}}
        </div>
    </div>
{!! Form::close() !!}

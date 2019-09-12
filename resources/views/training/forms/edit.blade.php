{!!Form::open(['route' => ['training.update',$training->id], 'method' => 'POST','class' =>'has-image-upload' ,'files' => true])!!}
    @method('PUT')
        <div class="form-group">
            {{form::label('training_title', 'Title')}}
            {{form::text('training_title',$training->title,['class'=>'form-control', 'placeholder'=>'Title of your training','required', 'autofocus'])}}
            @if ($errors->has('training_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('training_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group">
            {{form::label('training_content', 'Post content')}}
            {{form::textarea('training_content',$training->content,['class'=>'ckeditor form-control', 'placeholder'=>'content of your training...', 'required', 'autofocus'])}}
            @if ($errors->has('training_content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('training_content') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group justify-content-center">
                        <label for="">Update tags</label>
                        <tag-select :selected="{{$training->tags}}"></tag-select>
                    </div>
                </div>
            </div>
           
            {{Form::submit('Update training',['class' => 'btn btn-theme'])}}
        </div>
    </div>
{!! Form::close() !!}

<h6>Post Media</h6>

<div class="content-box">
    @if($training->media->count() > 0)
    {!!Form::open(['route' => ['training.media.remove',$training->id], 'method' => 'DELETE'])!!}
        <div class="row">
            @foreach($training->media as $media)
                <div class="col-sm-6 col-md-4 p-0">
                    <div class="p-1">
                        <div class="p-1" style="border: 1px solid #f2f2f2; border-radius: 3px">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="media-{{$media->id}}" name="media[]" value="{{$media->id}}">
                                <label class="custom-control-label" for="media-{{$media->id}}"> mark to remove</label>
                            </div>
                            @if($media->isPhoto())
                                @include('training.media.photo',['media' => $media])
                            @elseif($media->isVideo())
                                @include('training.media.video',['media' => $media])
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> remove selected media</button>
            </div>
        </div>
    {!! Form::close() !!}

    @else
            <p class="text-muted">The training has no media. Add Media</p>
    @endif
</div>

{!!Form::open(['route' => ['training.media.add',$training->id], 'method' => 'POST' ,'files' => true])!!}
    <div class="form-group">
        <label class="">Add photo/video to training</label>
        {{form::file('media[]',['class' => 'form-control','accept' =>'image/*,video/*', 'multiple'])}}
        @if ($errors->has('cover'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cover') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-times"></i> Add Media</button>
    </div>
{!! Form::close() !!}




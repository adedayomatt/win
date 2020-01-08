{!!Form::open(['route' => ['experience.update',$experience->id], 'method' => 'POST','class' =>'has-image-upload' ,'files' => true])!!}
    @method('PUT')
        <div class="form-group">
            {{form::label('experience_title', 'Title')}}
            {{form::text('experience_title',$experience->title,['class'=>'form-control', 'placeholder'=>'Title of your experience','required', 'autofocus'])}}
            @if ($errors->has('experience_title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('experience_title') }}</strong>
                </span>
            @endif
        </div>  

        <div class="form-group">
            {{form::label('experience_content', 'Post content')}}
            {{form::textarea('experience_content',$experience->content,['class'=>'ckeditor form-control', 'placeholder'=>'content of your experience...', 'required', 'autofocus'])}}
            @if ($errors->has('experience_content'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('experience_content') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group justify-content-center">
                    <label for="">Update tags</label>
                    <tag-select :selected="{{$experience->tags}}"></tag-select>
                </div>
            </div>
        </div>
        {{Form::submit('Update experience',['class' => 'btn btn-theme'])}}
{!! Form::close() !!}

<h6>Media</h6>

<div class="content-box">
    @if($experience->media->count() > 0)
    {!!Form::open(['route' => ['experience.media.remove',$experience->id], 'method' => 'DELETE'])!!}
        <div class="row">
            @foreach($experience->media as $media)
                <div class="col-sm-6 col-md-4 p-0">
                    <div class="p-1">
                        <div class="p-1" style="border: 1px solid #f2f2f2; border-radius: 3px">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="media-{{$media->id}}" name="media[]" value="{{$media->id}}">
                                <label class="custom-control-label" for="media-{{$media->id}}"> mark to remove</label>
                            </div>
                            @if($media->isPhoto())
                                @include('experience.media.photo',['media' => $media])
                            @elseif($media->isVideo())
                                @include('experience.media.video',['media' => $media])
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
            <p class="text-muted">The experience has no media. Add Media</p>
    @endif
</div>

{!!Form::open(['route' => ['experience.media.add',$experience->id], 'method' => 'POST' ,'files' => true])!!}
    <div class="form-group">
        <label class="">Add photo/video to experience</label>
        {{form::file('media[]',['class' => 'form-control','accept' =>'image/*,video/*', 'multiple'])}}
        @if ($errors->has('cover'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cover') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add Media</button>
    </div>
{!! Form::close() !!}




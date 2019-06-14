<div class="comment-area" style="background-color: #fff; border-top: 2px solid #f5f5f5">
    @auth
    @if(!auth()->user()->emailVerified())
        <div class="py-3 text-center text-muted">
            verify your email to comment on "{{str_limit($discussion->title, 100)}}"
        </div>
    @else
        {!!Form::open(['route' => ['comment.store',$discussion->slug], 'method' => 'POST'])!!}
            <img src="{{Auth::user()->avatar()['src']}}" alt="" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid #fff; position:absolute" data-toggle="tooltip" title="Add comment">
            <div style="position: absolute; right:25px; padding-top: 5px">
                {{Form::submit('Add comment',['class' => 'btn btn- btn-theme'])}}
            </div>
            <div>
                <textarea name="comment" placeholder="comment on {{str_limit($discussion->title,100)}}" style="height: 50px;padding: 10px 60px;width: 100%;border: none; " required>{{old('comment')}}</textarea>
                @if ($errors->has('comment'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                @endif
            </div>
        {!! Form::close() !!}
    @endif
    @endauth
    @guest
    <div class="py-3 text-center text-muted">
        <a href="{{route('login')}}">Sign in</a> or <a href="{{route('register')}}">Sign up</a> to contribute to "{{str_limit($discussion->title, 100)}}"
    </div>
    @endguest
</div>



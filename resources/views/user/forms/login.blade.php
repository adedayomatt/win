{!!Form::open(['route' => 'login'])!!}
    <div class="form-group">
        {{form::label('username','Username')}}
        {{form::text('username',old('username'),['class' =>'form-control','placeholder'=>'your username','required', 'autofocus'])}}
        @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('password','Password')}}
        {{form::password('password',['class' =>'form-control','placeholder'=>'password','required', 'autofocus'])}}
        @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group row justify-content-center">
        <div class="col-12">
            <div class="form-check">
            {{form::checkbox('remember','',old('remember') ? true : ''),['class'=>'form-check-input']}}
            {{form::label('remember',__('Remember Me'),['class'=>'form-check-label'])}}    
        </div>
        </div>
    </div>

    <div class="form-group">
            {{form::submit(__('Login'),['class'=>'btn btn-primary btn-block no-outline'])}}
    </div>
    @if (Route::has('password.request'))
        <div class="text-right">
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </div>
    @endif
{!!Form::close()!!}
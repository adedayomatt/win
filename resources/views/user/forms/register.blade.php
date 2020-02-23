{!!Form::open(['route' => 'register'])!!}
    <div class="form-group">
        {{form::label('firstname','First Name')}}
        {{form::text('firstname',old('firstname'),['class' =>'form-control','placeholder'=>'first name','required', 'autofocus'])}}
        @if ($errors->has('firstname'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('firstname') }}</strong>
        </span>
        @endif
    </div>
    <div class="form-group">
        {{form::label('lastname','Last Name')}}
        {{form::text('lastname',old('lastname'),['class' =>'form-control','placeholder'=>'last name','required', 'autofocus'])}}
        @if ($errors->has('lastname'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('lastname') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('username','Choose a username')}}
        {{form::text('username',old('username'),['class' =>'form-control','placeholder'=>'username','required', 'autofocus'])}}
        @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('email','E-mail address')}}
        <p class="help-text">Please use a valid email address because you will have to verify it</p>
        {{form::email('email',old('email'),['class' =>'form-control','placeholder'=>'working email address','required', 'autofocus'])}}
        @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('password','Create password')}}
        {{form::password('password',['class' =>'form-control','placeholder'=>'password','required', 'autofocus'])}}
        @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('password','')}}
        {{form::password('password_confirmation',['class' =>'form-control','placeholder' => 'Repeat password','required','autofocus'])}}
    </div>

    <div class="form-group">
            {{form::submit(__('Register'),['class'=>'btn btn-primary btn-block  no-outline'])}}
    </div>

{!!Form::close()!!}
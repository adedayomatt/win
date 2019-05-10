{!!Form::open(['route' => ['update.info',$user->username]])!!}
        @method('PUT')
        <div class="form-group">
            {{form::label('firstname','First Name')}}
            {{form::text('firstname',$user->firstname,['class' =>'form-control','placeholder'=>'first name','required', 'autofocus'])}}
            @if ($errors->has('firstname'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('firstname') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group">
            {{form::label('lastname','Last Name')}}
            {{form::text('lastname',$user->lastname,['class' =>'form-control','placeholder'=>'last name','required', 'autofocus'])}}
            @if ($errors->has('lastname'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('lastname') }}</strong>
            </span>
            @endif
        </div>

    <div class="form-group">
        {{form::label('username','change username')}}
        {{form::text('username',$user->username,['class' =>'form-control','placeholder'=>'username','required', 'autofocus'])}}
        @if ($errors->has('username'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('email','E-mail address')}}
        {{form::email('email',$user->email,['class' =>'form-control','placeholder'=>'working email address','required', 'autofocus', 'readonly'])}}
        @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        {{form::label('bio','Bio')}}
        {{form::textarea('bio',$user->bio,['class'=>'form-control','placeholder' => 'Something about you...','style' => 'height: 150px !important; resize: none'])}}
        @if ($errors->has('bio'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('bio') }}</strong>
        </span>
        @endif
    </div>


    <div class="form-group">
            {{form::submit('Update Info',['class'=>'btn btn-primary'])}}
    </div>

{!!Form::close()!!}
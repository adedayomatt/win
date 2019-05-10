{!!Form::open(['route' => ['update.work',$user->username]])!!}
        @method('PUT')
        <div class="form-group">
            {{form::label('company','Company')}}
            {{form::text('company',$user->company,['class' =>'form-control','placeholder'=>'where you currently work', 'autofocus'])}}
            @if ($errors->has('company'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('company') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            {{form::label('position','Your position')}}
            {{form::text('lastname',$user->position,['class' =>'form-control','placeholder'=>'your position at your workplace','required', 'autofocus'])}}
            @if ($errors->has('position'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('position') }}</strong>
            </span>
            @endif
        </div>


    <div class="form-group">
            {{form::submit('Save',['class'=>'btn btn-primary'])}}
    </div>

{!!Form::close()!!}
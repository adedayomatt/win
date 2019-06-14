{!!Form::open(['route' => ['update.education',$user->username]])!!}
        @method('PUT')
        <div class="form-group">
            {{form::label('school','School')}}
            {{form::text('school',$user->education == null ? '' : $user->education->school->name,['class' =>'form-control','placeholder'=>'school name...', 'autofocus'])}}
            @if ($errors->has('school'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('school') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            {{form::label('course','Course of study')}}
            {{form::text('course',$user->education == null ? '' : $user->education->course,['class' =>'form-control','placeholder'=>'what you study...','required', 'autofocus'])}}
            @if ($errors->has('course'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('course') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    {{form::label('start','started')}}
                    {{form::date('start',$user->education == null ? '' : $user->education->start_at,['class' =>'form-control','placeholder'=>'','required', 'autofocus'])}}
                    @if ($errors->has('start'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('start') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-6">
                    {{form::label('finish','Finished')}}
                    {{form::date('finish',$user->education == null ? '' : $user->education->finish_at,['class' =>'form-control','placeholder'=>'','required', 'autofocus'])}}
                    @if ($errors->has('finish'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('finish') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            
        </div>


    <div class="form-group">
            {{form::submit('Save',['class'=>'btn btn-primary'])}}
    </div>

{!!Form::close()!!}
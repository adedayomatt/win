{!!Form::open(['route' => ['update.work',$user->username]])!!}
        @method('PUT')
        <div class="form-group">
                {{form::label('company','Company')}}
            <div class="company-selection">
                {{form::text('company','',['class' =>'form-control company-search','placeholder'=>'where you currently work', 'autofocus'])}}
                <input type="hidden" name="company_id" value="">
            </div>

            @if ($errors->has('company'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('company') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            {{form::label('position','Your position')}}
            {{form::text('position',$user->work == null ? '' : $user->work->position,['class' =>'form-control','placeholder'=>'your position at your workplace', 'autofocus'])}}
            @if ($errors->has('position'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('position') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            {{form::label('job_description','Job Description')}}
            {{form::textarea('job_description',$user->work == null ? '' : $user->work->job_description,['class' =>'form-control textarea','placeholder'=>'your job description', 'autofocus'])}}
            @if ($errors->has('job_description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('job_description') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            {{form::label('start','started working here since...')}}
            {{form::date('start',$user->work == null ? '' : $user->work->start,['class' =>'form-control','placeholder'=>'', 'autofocus'])}}
            @if ($errors->has('start'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start') }}</strong>
            </span>
            @endif
        </div>


    <div class="form-group">
            {{form::submit('Save',['class'=>'btn btn-primary'])}}
    </div>

{!!Form::close()!!}
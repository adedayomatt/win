<div>Company</div>
<div class="content-box">
    {!!Form::open(['route' => ['update.work',$user->username]])!!}
        @method('PUT')
        <div class="form-group">
                <div id="company-selection">
                <company-search container="#company-selection" data="{{$user->work == null ? null : $user->work->company}}"></company-search>
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
            {{form::label('started_at','started working here since...')}}
            {{form::date('started_at',$user->work->started_at == null ? '' : $user->work->started_at->format('Y-m-d'),['class' =>'form-control','placeholder'=>'', 'autofocus'])}}
            @if ($errors->has('started_at'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('started_at') }}</strong>
            </span>
            @endif
        </div>


        <div class="form-group">
                {{form::submit('Save',['class'=>'btn btn-primary'])}}
        </div>

    {!!Form::close()!!}
</div>

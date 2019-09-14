<div>School</div>
<div class="content-box">
        {!!Form::open(['route' => ['update.education',$user->username]])!!}
            @method('PUT')

            <div class="form-group">
                <div id="school-selection">
                    <school-search container="#school-selection" data="{{$user->education == null ? null : $user->education->school}}"></school-search>
                </div>
                @if ($errors->has('school'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('school') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                {{form::label('course','Course of study')}}
                {{form::text('course',$user->education == null ? '' : $user->education->course,['class' =>'form-control','placeholder'=>'what you study...', 'autofocus'])}}
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
                        {{form::date('start',$user->education == null || $user->education->started_at == null ? '' : $user->education->started_at->format('Y-m-d'),['class' =>'form-control','placeholder'=>'', 'autofocus'])}}
                        @if ($errors->has('start'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('start') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-6">
                        {{form::label('finish','Finished')}}
                        {{form::date('finish',$user->education == null || $user->education->finished_at == null? '' : $user->education->finished_at->format('Y-m-d'),['class' =>'form-control','placeholder'=>'', 'autofocus'])}}
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
</div>

@extends('layouts.app')
@section('h-scripts')
    @include('layouts.components.typeahead.company')
    @include('layouts.components.typeahead.school')
@endsection
@section('main')
<div class="mt-50">
    <div class="row justify-content-center">
        <div class="col-md-8 no-padding-xs">
            <div class="content-box mt-">
                <div class="row">
                    <div class="col-sm-4">
                        @include('user.widgets.snippet')
                        <h5 class="my-2 grey"><i class="fa fa-cog"></i> Settings</h5>
                        <ul class="list-group">
                            <li class="list-group-item" data-toggle="collapse" data-target="#info" aria-expanded="true" aria-controls="info">
                               <i class="fa fa-info-circle"></i> Info
                            </li>
                            <li class="list-group-item" data-toggle="collapse" data-target="#interests" aria-expanded="true" aria-controls="interests">
                                <i class="fa fa-hashtag"></i> Interests
                            </li>
                            <li class="list-group-item" data-toggle="collapse" data-target="#education" aria-expanded="true" aria-controls="education">
                                <i class="fa fa-graduation-cap"></i> Education
                            </li>
                            <li class="list-group-item" data-toggle="collapse" data-target="#work" aria-expanded="true" aria-controls="work">
                                <i class="fa fa-briefcase"></i> Work
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-8">
                        <div id="settings">
                            <div id="info" class="collapse {{$tab === null || $tab === 'info' ? 'show' : '' }}"  data-parent="#settings">
                                <h5 class="card-title text-muted"><i class="fa fa-info-circle"></i> Info</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @include('user.settings.info')
                                    </div>
                                </div>
                            </div>
                           
                            <div id="interests" class="collapse {{$tab === 'interests' ? 'show' : '' }}" data-parent="#settings">
                                <h5 class="card-title text-muted"><i class="fa fa-hashtag"></i> Interests</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @include('user.settings.interests', ['update' => true])
                                    </div>
                                </div>
                            </div>

                            <div id="education" class="collapse {{$tab === 'education' ? 'show' : '' }}" data-parent="#settings">
                                <h5 class="card-title text-muted"><i class="fa fa-graduation-cap"></i> Education</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @if($user->hasEducation())
                                            <div class="form-group">
                                                School: <strong>{{$user->education->school->name}}</strong>
                                            </div>
                                            <div class="form-group">
                                                Course of study: <strong>{{$user->education->course}}</strong>
                                            </div>
                                            <div class="form-group">
                                                From: {{$user->education->started_at == null ? 'N/A' : $user->education->started_at}}
                                            </div>
                                            <div class="form-group">
                                                To: {{$user->education->finished_at == null ? 'N/A' : $user->education->finished_at}}
                                            </div>
                                            <div class="text-right">
                                                <i class="fa pen operation" data-toggle="collapse" data-target="#edit-education"></i>
                                                <i class="fa fa-times"></i> remove
                                            </div>
                                            <div class="collapse" id="edit-education">
                                                @include('user.settings.education')
                                            </div>
                                        @else
                                            @include('user.settings.education')
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="work" class="collapse {{$tab === 'work' ? 'show' : '' }}" data-parent="#settings">
                                <h5 class="card-title text-muted"><i class="fa fa-briefcase"></i> Work</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @if($user->hasWork())
                                            <div class="form-group">
                                                Company: <strong>{{$user->work->company->name}}</strong>
                                            </div>
                                            <div class="form-group d-flex">
                                               <div>Position:</div> 
                                               <div class="ml-2">
                                                    <strong class="d-block">{{$user->work->position == null ? 'N/A' : $user->work->position}}</strong>
                                                    <small class="text-muted">{{$user->work->job_description == null ? '' : $user->work->job_description}}</small>
                                               </div>
                                            </div>
                                            <div class="form-group">
                                                Since: {{$user->work->started_at == null ? 'N/A' : $user->work->started_at}}
                                            </div>
                                            <div class="text-right">
                                                <i class="fa pen operation" data-toggle="collapse" data-target="#edit-work"></i>
                                                <i class="fa fa-times"></i> remove
                                            </div>
                                            <div class="collapse" id="edit-work">
                                                @include('user.settings.work')
                                            </div>
                                        @else
                                            @include('user.settings.work')
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                        
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

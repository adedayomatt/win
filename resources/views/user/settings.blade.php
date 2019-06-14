@extends('layouts.app')

@section('main')
<div class="mt-50">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="content-box mt-5">
                <div class="row">
                    <div class="col-sm-4">
                        @include('user.widgets.snippet')
                        <h5 class="my-2 grey">Settings</h5>
                        <ul class="list-group">
                            <li class="list-group-item" data-toggle="collapse" data-target="#info" aria-expanded="true" aria-controls="info">
                                Info
                            </li>
                            <li class="list-group-item" data-toggle="collapse" data-target="#interests" aria-expanded="true" aria-controls="interests">
                                Interests
                            </li>
                            <li class="list-group-item" data-toggle="collapse" data-target="#education" aria-expanded="true" aria-controls="education">
                                Education
                            </li>
                            <li class="list-group-item" data-toggle="collapse" data-target="#work" aria-expanded="true" aria-controls="work">
                                Work
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-8">
                        <div id="settings">
                            <div id="info" class="collapse {{$tab === null || $tab === 'info' ? 'show' : '' }}"  data-parent="#settings">
                                <h5 class="card-title grey">Info</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @include('user.settings.info')
                                    </div>
                                </div>
                            </div>
                           
                            <div id="interests" class="collapse {{$tab === 'interests' ? 'show' : '' }}" data-parent="#settings">
                                <h5 class="card-title grey">Interests</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @include('user.settings.interests', ['update' => true])
                                    </div>
                                </div>
                            </div>

                            <div id="education" class="collapse {{$tab === 'education' ? 'show' : '' }}" data-parent="#settings">
                                <h5 class="card-title grey">Education</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @include('user.settings.education')
                                    </div>
                                </div>
                            </div>

                            <div id="work" class="collapse {{$tab === 'work' ? 'show' : '' }}" data-parent="#settings">
                                <h5 class="card-title grey">Work</h5>
                                <div class="card">
                                    <div class="card-body">
                                        @include('user.settings.work')
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
